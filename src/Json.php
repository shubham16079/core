<?php
namespace App;
class Json
{
    public static function getDataInJson($data)
    {
        header('Content-Type: application/json');
        return json_encode($data,JSON_PRETTY_PRINT);

    }
}