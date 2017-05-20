<?php

/**
 * File: Mail.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/3/26 12:34
 * Description:
 */
class Mail
{
    public static function quickSend($sendTo, $title, $content)
    {
        $email = Yii::app()->getComponent('mail');
        if (!empty($email)) {
            $message = new YiiMailMessage();
            try {
                $message->setSubject('[Wakfu]' . $title)->setBody($content)
                    ->setSender("toruneko@sina.com")->setFrom("toruneko@sina.com")->addTo($sendTo);
                $email->send($message);
            } catch (Exception $e) {
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'Yii-mailler');
            }
        }
    }
}