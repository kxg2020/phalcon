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

    /**
     * 上传图片
     */
    public function uploadAction(){

        $res = $this->upload->uploadOne(array_shift($_FILES));

        //>> 判断是否上传成功
        if(!empty($res)){

            return json_encode($res);
        }else{

            die($this->common->_printError('10000'));
        }
    }
}