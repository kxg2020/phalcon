<?php
namespace Multiple\Backend\Controllers;

use Multiple\Backend\Models\XmImage;
use Phalcon\Mvc\Controller;

class ImageController extends Controller{

    /**
     * 展示页面
     */
    public function listAction(){

        $paramArr = $_REQUEST;
        $pgNum = 1;
        $pgSize = 6;
        if(!empty($paramArr)){
            if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum']) && $paramArr['pgNum'] < 1000){

                $pgNum = $paramArr['pgNum'];
            }
            if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize']) && $paramArr['pgSize'] < 30){

                $pgSize = $paramArr['pgSize'];
            }
        }
        $imageModel = new XmImage();

        $imageList = $imageModel->imageList();

        if(!empty($imageList)){

            foreach($imageList as $key => &$value){
                $value['date'] = date('Y-m-d',$value['create_time']);
            }
            unset($value);

        }

        $count = count($imageList);

        $pages = ceil($count/$pgSize);

        $images = $this->pagination($imageList,$pgNum,$pgSize);

        if($this->request->isAjax()){
            die($this->common->_printSuccess(['list'=>array_values($images)]));
        }

        $this->view->pick('image/list')->setVars(['images'=>$images,'pages'=>$pages]);
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

        if(!empty($res)){

            $insertData = [
                'image_url'=>$res['url'],
                'type'=>1,
                'create_time'=>time(),
                'is_active'=>1,
                'sort'=>1
            ];

            $result = $this->mysql->insertData($insertData,'xm_image');

            if($result){

                return json_encode($res);
            }else{

                die($this->common->_printError('10001'));
            }
        }else{

            die($this->common->_printError('10000'));
        }
    }

    /**
     * 图片分页
     */
    public function pagination($images = [],$pgNum = '',$pgSize = ''){

        if(empty($images)) return false;

        $start = ($pgNum - 1) * $pgSize;

        $sliceArr = array_slice($images,$start,$pgSize);

        return $sliceArr;
    }

    /**
     * 修改状态
     */
    public function changeAction(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

           if(isset($paramArr['is_active']) && is_numeric($paramArr['is_active'])){
               $updateData = [
                   'is_active'=>$paramArr['is_active'],
                   'icon' => $paramArr['is_active'] ? 'icon-ok' :'icon-remove'
               ];
               $res = $this->mysql->updateData(['id'=>$paramArr['id']],$updateData,'xm_image');

               if(false == $res){

                   die($this->common->_printError('10003'));
               }else{

                   die($this->common->_printSuccess());
               }
           }else{

               die($this->common->_printError('10002'));
           }
        }else{

            die($this->common->_printError('10002'));
        }
    }

    /**
     * 删除图片
     */
    public function deleteAction(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            if(isset($paramArr['id'])  && is_numeric($paramArr['id'])){

                $imageModel = new XmImage();

                $res = $imageModel->imageDelete($paramArr['id']);

                if($res){

                    die($this->common->_printSuccess());
                }else{

                    die($this->common->_printError('10004'));
                }
            }else{

                die($this->common->_printError('10004'));
            }
        }else{

            die($this->common->_printError('10002'));
        }
    }
}