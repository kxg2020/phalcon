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
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
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
$di->set('mysql', function (){
    $config = $this->getConfig();
    return MysqlDatabase::getIns('database',$config);
},true);

$di->set('upload', function (){
    $_config = [
    'maxSize'       =>  1024*1024*5, //上传的文件大小限制 (0-不做限制)
    'exts'          =>  array('jpg', 'png', 'gif', 'jpeg'),
    'rootPath'      =>  './uploads/', //保存根路径
    ];
    $config = [
    'FILE_UPLOAD_TYPE'=>'Qiniu',
    'secretKey'      => '-ozcCzNuPfZQePdMUtEHzp6gfuQQfS-GR4IOmxen', //七牛密码
    'accessKey'      => 'Oxorx2oRMYXe8bZCRvuoNpyOexkJAgKPgs14Gv4O', //七牛用户
    'domain'         => 'on58ea572.bkt.clouddn.com', //域名
    'bucket'         => 'macarin', //空间名称
    'timeout'        => 300, //超时时间
    ];
    return new Uploads($_config,'',$config);
},true);

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

//>> 注册EXCEL组件 Register a PHPExcel component
$di->set('phpexcel', function(){
    return new PHPExcelTreat();
});

$di->setShared('aes256',function(){
    return new AES256();
});




