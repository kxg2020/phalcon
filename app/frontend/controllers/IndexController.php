<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * չʾ��ҳ
     */
    public function indexAction(){


        $this->view->pick('index/index');
    }
}