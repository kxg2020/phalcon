<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class PhotoController extends Controller{

    /**
     * ÕÕÆ¬Ç½
     */
    public function listAction(){

        $this->view->pick('photo/index');
    }
}