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


        echo 1;
        $this->view->pick('image/add');
    }

    /**
     * 上传图片
     */
    public function uploadAction(){

        $res = $this->upload->uploadOne($_FILES);
        //>> 判断是否上传成功
        if($res){

            die($this->common->_printSuccess(['status'=>1,'url'=>$res['url']]));

        }else{

            die($this->common->_printError('10000'));
        }
    }
}