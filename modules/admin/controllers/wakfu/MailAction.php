<?php

/**
 * File: MailAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/10/19 23:50
 * Description:
 */
class MailAction extends RedAction
{
    public function run()
    {
        $model = new MailForm();

        if (($post = $this->request->getPost('MailForm', false)) !== false) {
            $model->attributes = $post;
            if ($model->validate()) {
                $model->push();
                $this->response(200, "发送邮件完成");
                $this->app->end();
            }
        }

        $this->render('mail', array(
            'model' => $model,
        ));
    }
}