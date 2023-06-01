<?php
namespace App;

use Exception;

class UsersController
{
    /**
     * @throws Exception
     */
    public function getusers()
    {
        $model = new Model();
        return $model->query('users')
            ->fields(['id', 'first_name', 'mobile'])
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->where('id', '=', 693980)
            ->getData();
    }
}