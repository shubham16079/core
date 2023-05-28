<?php
namespace App;

class UsersController
{
    /**
     * @return false|array|null
     */
    public function getusers()
    {
        $model = new Model();
        $model->setTable('users');
        $model->fields(['id', 'first_name', 'mobile']);
        $model->orderBy('id');
        $model->limit(10);
//        $model->where('id', '=', '2');
        return $model->getData();
    }
}