<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * չʾ��ҳ
     */
    public function indexAction(){

        //>> ��ѯbannerͼ
        $where = ['is_banner'=>1];
        $bannerList  = $this->mysql->getList($where,'image_url',' create_time desc,sort asc','','','xm_image');

        $this->view->pick('index/index')->setVars(['list'=>$bannerList['allrow']]);
    }
}