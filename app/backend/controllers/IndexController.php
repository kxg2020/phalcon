<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{

    /**
     * չʾ��¼ҳ
     */
    public function loginAction(){

        $this->view->pick('index/login');

    }

    /**
     * չʾ��ҳ
     */
    public function indexAction(){

        $this->view->pick('index/index');

    }


}