<?php

use App\Json;

require 'vendor/autoload.php';

$controllerName = $_REQUEST['controller'] ?? '';
$actionName = $_REQUEST['action'] ?? '';

$controllerClassName = 'App\\' . $controllerName . 'Controller';

if (!class_exists($controllerClassName)) {
    throw new Exception('Class Not Found');
}

$controllerObj = new $controllerClassName();

if (!method_exists($controllerObj, $actionName)) {
    throw new Exception('action Not Found');
}

echo Json::getDataInJson($controllerObj->$actionName());
