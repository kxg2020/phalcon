<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * չʾ��ҳ
     */
    public function indexAction(){

        //>> ��ѯbannerͼ
        $bannerList = $this->mysql->getList('','*','create_time desc','','','xm_banner');

        $this->view->pick('index/index')->setVars(['list'=>$bannerList['allrow']]);
    }
}