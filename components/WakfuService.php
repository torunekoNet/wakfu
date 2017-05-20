<?php
use \net\toruneko\wakfu\interfaces\WakfuServiceClient;

/**
 * File: WakfuService.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/3 11:40
 * Description:
 */
class WakfuService
{
    public function create($service)
    {
        $service->server = $this->getRandomIp();
        $service->port = $this->getRandomPort();
        return $this->savePort($service->port);
    }

    public function remove($service)
    {
        $service->server = "";
        $service->port = 0;
        $service->pac = "";
        $service->status = 2;
        return true;
    }

    public function open($service, $status = 0)
    {
        if (in_array($service->status, array(0, 3))) return false; // 可用状态

        $client = new WakfuServiceClient(null);
        try {
            Yii::app()->thrift->build($client);
            if ($client->open($service->server, $service->port)) {
                $service->status = $status; // 启用状态
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            return false;
        }
    }

    public function close($service, $status = 2)
    {
        if (in_array($service->status, array(1, 2))) return false; // 不可用状态

        $client = new WakfuServiceClient(null);
        try {
            Yii::app()->thrift->build($client);
            if ($client->close($service->server, $service->port)) {
                $service->status = $status; // 默认禁用状态
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            return false;
        }
    }

    public function view($service)
    {
        $client = new WakfuServiceClient(null);
        try {
            Yii::app()->thrift->build($client);
            $traffic = $client->view($service->server, $service->port);
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            $traffic = -1;
        }
        if ($traffic >= 0) {
            /**
             * 返回的是KB。计算单位是MB*100。因此$traffic / 1000 * 100
             */
            $traffic = round($traffic / 10);
            if ($traffic >= $service->used) {
                $service->left -= ($traffic - $service->used);
            } else {
                $service->left -= $traffic;
            }
            $service->used = $traffic;
            if ($service->left <= 0) {
                $this->close($service, 1); //欠费状态
            }

            return true;
        } else {
            return false;
        }
    }

    public function pac($service)
    {
        $server = $this->getServerByIp($service->server);

        if ($service->status == 3) { //幸存模式
            return 'function FindProxyForURL(url, host) { return "SOCKS5 ' . $server . ':' . $service->port . '; SOCKS ' . $server . ':' . $service->port . '" }';
        } else {
            $client = new WakfuServiceClient(null);
            try {
                Yii::app()->thrift->build($client);
                return $client->pac($server, $service->port, $service->rules);
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
                return false;
            }
        }
    }

    public function savePac($service, $pac)
    {
        $server = $this->getServerByIp($service->server);
        $filename = substr(md5($server . ":" . $service->port), 8, 16) . '.pac';
        $options = array(
            'content' => $pac,
            'Content-Type' => 'application/x-ns-proxy-autoconfig'
        );

        Yii::import('ext.oss_php_sdk_20150819.alioss', true);
        $alioss = new ALIOSS(OSS_ACCESS_ID, OSS_ACCESS_KEY, OSS_ENDPOINT);
        $response = $alioss->upload_file_by_content(OSS_BUCKET, "pac/" . $filename, $options);
        if ($response->status == 200) {
            return "http://assets.toruneko.net/pac/" . $filename;
        } else {
            return false;
        }
    }

    public function createChromeBak($service)
    {
        $server = $this->getServerByIp($service->server);

        $chrome = <<<STR
{"-confirmDeletion":true,"-downloadInterval":720,"-enableQuickSwitch":false,"-exportLegacyRuleList":true,"-monitorWebRequests":true,"-quickSwitchProfiles":[],"-refreshOnProfileChange":false,"-revertProxyChanges":false,"-showInspectMenu":true,"-startupProfileName":"","schemaVersion":2,"+全局代理":{"bypassList":[{"conditionType":"BypassCondition","pattern":"<local>"}],"color":"#9d9","fallbackProxy":{"host":"{[:server]}","port":{[:port]},"scheme":"socks5"},"name":"全局代理","profileType":"FixedProfile","revision":"14f69ea40f6"},"+智能分流":{"color":"#d497ee","lastUpdate":"","name":"智能分流","pacScript":"","pacUrl":"{[:pacUrl]}","profileType":"PacProfile","revision":"14f6a201b1f"},"+自动切换":{"profileType":"SwitchProfile","name":"自动切换","defaultProfileName":"智能分流","rules":[],"color":"#9ce","revision":"14f6a1fbe64"}}
STR;
        $chrome = str_replace(array(
            '{[:server]}',
            '{[:port]}',
            '{[:pacUrl]}',
        ), array($server, $service->port, $service->pac), $chrome);

        $filename = substr(md5($server . ":" . $service->port), 8, 16) . '.bak';
        $options = array(
            'content' => $chrome,
        );

        Yii::import('ext.oss_php_sdk_20150819.alioss', true);
        $alioss = new ALIOSS(OSS_ACCESS_ID, OSS_ACCESS_KEY, OSS_ENDPOINT);
        $response = $alioss->upload_file_by_content(OSS_BUCKET, "chrome/" . $filename, $options);
        if ($response->status == 200) {
            return true;
        } else {
            return false;
        }
    }

    private function savePort($port)
    {
        $except = Setting::model()->get('wakfu', 'except');
        $except[] = $port;
        return Setting::model()->set('wakfu', 'except', $except);
    }

    private function getRandomPort()
    {
        $except = Setting::model()->get('wakfu', 'except');
        $port = Setting::model()->get('wakfu', 'port');
        $list = range($port[0], $port[1]);
        $diffList = array_diff($list, $except);
        shuffle($diffList);
        return array_pop($diffList);
    }

    private function getRandomIp()
    {
        $server = Setting::model()->get('wakfu', 'ip');
        shuffle($server);
        return array_pop($server);
    }

    private function getServerByIp($ip)
    {
        $server = Setting::model()->get('wakfu', 'server');
        if (isset($server[$ip])) {
            return $server[$ip];
        } else {
            return $ip;
        }
    }
}