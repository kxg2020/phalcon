<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{

    /**
     * 展示登录页
     */
    public function loginAction(){

        $this->view->pick('index/login');

    }

    /**
     * 展示首页
     */
    public function indexAction(){

        $this->view->pick('index/index');

    }


}