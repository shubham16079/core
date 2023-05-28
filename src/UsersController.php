<?php
namespace App;
use App\Model;

class UsersController
{
    public function getusers()
    {
        $model = new Model();
        $model->setTable('users');
        $model->fields(['id', 'first_name', 'mobile']);
        $model->orderBy('id');
        $model->limit(2);
        $model->where('id', '=', '2');
        return $model->getData();
    }
}