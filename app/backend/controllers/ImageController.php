<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ImageController extends Controller{

    /**
     * չʾҳ��
     */
    public function indexAction(){

        $this->view->pick('image/index');
    }

    /**
     * ���ͼƬ
     */
    public function addAction(){

        $res = $this->mysql->getList(['id'=>1],'*','','','','xm_banner');
        var_dump($res);exit;
        $this->view->pick('image/add');
    }
}