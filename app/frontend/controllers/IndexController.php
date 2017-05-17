<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * 展示首页
     */
    public function indexAction(){


        //>> 查询banner图
        $bannerList = $this->mysql->getList(['is_active'=>1],'*','create_time desc','','','xm_image');

        $this->view->pick('index/index')->setVars(['list'=>$bannerList['allrow']]);

    }

    public function exampleAction(){


        $str = $this->redis->get('name');
        $str = json_decode($str);

       var_dump($str);

    }

    public function show404Action(){

        echo  "页面没有";
    }
}