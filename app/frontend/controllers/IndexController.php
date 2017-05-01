<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * 展示首页
     */
    public function indexAction(){

        //>> 查询banner图
        $bannerList = $this->mysql->getList('','*','create_time desc','','','xm_banner');

        $this->view->pick('index/index')->setVars(['list'=>$bannerList['allrow']]);
    }
}