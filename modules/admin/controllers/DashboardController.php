<?php

/**
 * file:DashboardController.php
 * author:Toruneko@outlook.com
 * date:2014-7-14
 * desc:仪表盘
 */
class DashboardController extends Controller
{

    public function actionSysInfo()
    {
        $this->render('sysInfo');
    }

    public function actionUserInfo()
    {
        $this->render('userInfo');
    }

    public function actionSetting()
    {
        $operationType = $this->request->getQuery('operationType', 'view');
        if (method_exists($this, $operationType)) {
            call_user_func(array($this, $operationType));
        } else {
            $this->view();
        }
    }

    private function add()
    {
        $post = $this->request->getPost('Setting');
        if (empty($post)) {
            $this->response(404, '参数缺失');
        } else {
            $exists = Setting::model()->findByAttributes(array(
                'section' => $post['section'],
                'name' => $post['name'],
            ));
            if (empty($exists)) {
                $model = new Setting();
                $model->attributes = array(
                    'section' => $post['section'],
                    'name' => $post['name'],
                    'value' => CJSON::encode(explode(',', $post['value']))
                );
                if ($model->save()) {
                    $this->response(200, '添加成功');
                } else {
                    $this->response(500, '添加失败');
                }
            } else {
                $exists->value = CJSON::encode(explode(',', $post['value']));
                if ($exists->save()) {
                    $this->response(200, '修改成功');
                } else {
                    $this->response(500, '修改失败');
                }
            }
        }
    }

    private function view()
    {
        $query = $this->request->getPost('Setting', array());
        $model = Setting::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $data = $model->findAll($condition);
        $this->render('setting', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
        ));
    }

    private function createSearchCriteria($data = array())
    {
        $condition = '';
        $params = array();
        if (!empty($data)) {
            $con = array();
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                $con[] = $key . '=:' . $key;
                $params[$key] = $value;
            }
            $condition = join(' AND ', $con);
        }
        return array('condition' => $condition, 'params' => $params);
    }
}