<?php
namespace Multiple\Backend\Controllers;

use Multiple\Backend\Models\XmArticle;
use Phalcon\Mvc\Controller;

class ArticleController extends Controller{

    /**
     * 文章列表
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
        $articleList = $this->mysql->getList('','*','create_time desc','','','xm_article');

        foreach($articleList['allrow'] as $key => &$value){
            $value['date'] = date('Y-m-d',$value['create_time']);
        }
        unset($value);

        $count = count($articleList['allrow']);

        $pages = ceil($count/$pgSize);

        $articles = $this->common->pagination($articleList['allrow'],$pgNum,$pgSize);

        if($this->request->isAjax()){
            die($this->common->_printSuccess(['list'=>array_values($articles)]));
        }
        $this->view->pick('article/list')->setVars([
            'articles'=>$articles,
            'pages'=>$pages
        ]);
    }

    /**
     * 添加文章
     */
    public function addAction(){

       if($this->request->isAjax()){
           $paramArr = $_REQUEST;

           if(!empty($paramArr)){

               if(isset($paramArr['content']) && !empty($paramArr['content'])){

                   $insertData = [
                       'content'=>$paramArr['content'],
                       'create_time'=>time(),
                       'author'=>'Macarinal',
                       'title'=>$paramArr['title'],
                       'type'=>1
                   ];
                   $res = $this->mysql->insertData($insertData,'xm_article');
                   if($res){

                       die($this->common->_printSuccess());
                   }else{

                       die($this->common->_printError('10005'));
                   }
               }
           }else{

               die($this->common->_printError('10002'));
           }
       }
        $this->view->pick('article/add');
    }

    /**
     * 删除文章
     */
    public function deleteAction(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){
            if(isset($paramArr['id']) && !empty($paramArr) && is_numeric($paramArr['id'])){

                $articleModel = new XmArticle();
                $res = $articleModel->articleDelete($paramArr['id']);
                if($res){

                    die($this->common->_printSuccess());
                }else{

                    die($this->common->_printError('10004'));
                }
            }else{

                die($this->common->_printError('10002'));
            }
        }else{

            die($this->common->_printError('10002'));
        }
    }


    /**
     * 上传图片
     */
    public function uploadAction(){

        $callback = $_REQUEST["CKEditorFuncNum"];
        $res = $this->upload->uploadOne(array_shift($_FILES));

        if(!empty($res)){
            echo "
<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'".$res['url']."','');</script>
";
        }else{

            die($this->common->_printError('10000'));
        }
    }
}