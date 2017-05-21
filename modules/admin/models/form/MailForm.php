<?php

/**
 * File: MailForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/10/19 23:53
 * Description:
 */
class MailForm extends CFormModel
{
    public $title;
    public $content;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('title', 'required', 'message' => '请输入' . $labels['title']),
            array('content', 'required', 'message' => '请输入' . $labels['content']),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'title' => '标题',
            'content' => '正文',
        );
    }

    public function push()
    {
        $services = Service::model()->findAllByAttributes(array('status' => 0));
        $accessKey = Yii::app()->params['secretKey'];
        $url = Yii::app()->createUrl('api/mail');
        $task = array();
        foreach ($services as $service) {
            $task[] = array(
                'url' => $url,
                'postdata' => CJSON::encode(array(
                    'uid' => $service->email,
                    'title' => $this->title,
                    'content' => $this->content,
                    'accessKey' => $accessKey
                ))
            );
        }
        WakfuQueue::enqueue($task);
    }
}