<?php

/**
 * File: QueueAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/3/26 16:19
 * Description:
 */
class QueueAction extends RedAction
{
    public function run()
    {
        $query = $this->request->getQuery('Queue', array());
        $model = Queue::model();
        $model->attributes = $query;
        $condition = $this->createSearchCriteria($query);
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'id desc';
        $data = $model->findAll($condition);
        $this->render('queue', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'model' => $model,
        ));
    }
}