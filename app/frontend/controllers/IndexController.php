<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * Õ¹Ê¾Ê×Ò³
     */
    public function indexAction(){


        $this->view->pick('index/index');
    }
}