<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'root',
        'dbname'      => 'xm_db',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => APP_PATH . '/cache/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],

    'redis'=>[
        'host'=>'127.0.0.1',
        'port'=>'6379',
    ],

    'upload'=>[

        'uploads'=>[
            'maxSize'       =>  1024*1024*5, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  array('jpg', 'png', 'gif', 'jpeg'),
            'rootPath'      =>  './uploads/', //保存根路径]
        ],

        'Qiniu'=>[
            'FILE_UPLOAD_TYPE'=>'Qiniu',
            'secretKey'      => '-ozcCzNuPfZQePdMUtEHzp6gfuQQfS-GR4IOmxen', //七牛密码
            'accessKey'      => 'Oxorx2oRMYXe8bZCRvuoNpyOexkJAgKPgs14Gv4O', //七牛用户
            'domain'         => 'on58ea572.bkt.clouddn.com', //域名
            'bucket'         => 'macarin', //空间名称
            'timeout'        => 300, //超时时间
        ],
        ]

]);
