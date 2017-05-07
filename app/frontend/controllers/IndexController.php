<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * 展示首页
     */
    public function indexAction(){

        //>> 查询banner图
        $where = ['is_banner'=>1];
        $bannerList  = $this->mysql->getList($where,'image_url',' create_time desc,sort asc','','','xm_image');

        $this->view->pick('index/index')->setVars(['list'=>$bannerList['allrow']]);
    }
}