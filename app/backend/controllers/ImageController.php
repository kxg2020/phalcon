<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ImageController extends Controller{

    /**
     * 展示页面
     */
    public function indexAction(){

        $this->view->pick('image/index');
    }

    /**
     * 添加图片
     */
    public function addAction(){

        $this->view->pick('image/add');
    }
}