<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ArticleController extends Controller{

    /**
     * ����ҳ��
     */
    public function listAction(){

        $this->view->pick('article/index');
    }
}