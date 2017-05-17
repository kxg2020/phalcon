<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Events\Manager as EventManager;


/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {

    $config = $this->getConfig()->database;

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->adapter;
    $params = [
        'host'     => $config->host,
        'username' => $config->username,
        'password' => $config->password,
        'dbname'   => $config->dbname,
        'charset'  => $config->charset
    ];

    if ($config->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {

    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {

    $session = new SessionAdapter();

    $session->start();

    return $session;
});


//>> 操作数据库类
$di->setShared('mysql', function (){
    $config = $this->getConfig();

    return MysqlDatabase::getIns('database',$config);
});

$di->setShared('upload', function (){
    $config = $this->getConfig->upload;

    return new Uploads($config['upload'],'',$config['Qiniu']);
});

//>> 工具类
$di->set('utils',function (){

    return new LibUtil();
});

//>>Redis缓存
$di->setShared('redis',function (){

    $config = $this->getConfig()->redis;

    $redis = new Redis();

    $redis->connect($config['host'],$config['port']);

    return $redis;
});

//>>事务
$di->setShared( "transactions",function () {
    return new TransactionManager();
});

//>> 错误消息类
$di->set('errmsg',function(){
    return new GetErrMsg();
});

//>> 注册常用类
$di->setShared('common', function (){
    return new Common();
});

//>> 注册EXCEL组件
$di->set('phpexcel', function(){
    return new PHPExcelTreat();
});

$di->setShared('aes256',function(){
    return new AES256();
});
/**
 * 未找到控制器和方法
 */
$di->setShared('dispatcher', function() {
    //事件管理类
    $eventsManager = new EventManager();
    //监听一个事件
    $eventsManager->attach("dispatch", function ($event, $dispatcher, $exception) {
        //如果控制器存在，但方法不存在,就跳转到指定的控制器和方法
        if ($event->getType() == 'beforeNotFoundAction') {
            $dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'show404'
            ));
            return false;
        }
        //如果控制器和方法都不存在,跳转到指定的控制器和方法
        if ($event->getType() == 'beforeException') {
            switch ($exception->getCode()) {
                case Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'show404'
                    ));
                    return false;
            }
        }
    });
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    //绑定事件管理器到调度器上
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});




