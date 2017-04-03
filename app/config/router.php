<?php

use Phalcon\Mvc\Router;
use Phalcon\Tag;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$di->set('router', function () {

    $router = new Router();

    $router->setDefaultModule("frontend");

    $router->setDefaults(array(
        "namespace" => 'Multiple\Frontend\Controllers',
        "controller" => "Index",
        "action" => "index"
    ));

    //>>frontend
    $router->add("/frontend", array(
        'module'=>'frontend',
        'controller' => 'index',
        'action'=>'index'
    ));
    $router->add("/frontend/:controller", array(
        'module'=>'frontend',
        'controller' => 1,
        'action'     => 2,
    ));
    $router->add("/frontend/:controller/:action", array(
        'module'=>'frontend',
        'controller' => 1,
        'action'     => 2,
    ));
    $router->add("/frontend/:controller/:action", array(
        'module'=>'frontend',
        'controller' => 1,
        'action'     => 2,
    ));
    $router->add("/frontend/:controller/:action/:params", array(
        'module'=>'frontend',
        'controller' => 1,
        'action'     => 2,
        'params'      => 3,
    ));


    //>>backend
    $router->add("/backend", array(
        'module'=>'backend',
        'namespace'=>'Multiple\Backend\Controllers', //　一定要加上，要不然找不到后台
        'controller' => 'index',
        'action'=>'login',
    ));
    $router->add("/backend/:controller", array(
        'module'=>'backend',
        'namespace'=>'Multiple\Backend\Controllers', //　一定要加上，要不然找不到后台
        'controller' => 1,
    ));
    $router->add("/backend/:controller/:action", array(
        'module'=>'backend',
        'namespace'=>'Multiple\Backend\Controllers',
        'controller' => 1,
        'action'     => 2,
    ));
    $router->add("/backend/:controller/:action/:params", array(
        'module'=>'backend',
        'namespace'=>'Multiple\Backend\Controllers',
        'controller' => 1,
        'action'     => 2,
        'params'      => 3,
    ));

    return $router;
});

