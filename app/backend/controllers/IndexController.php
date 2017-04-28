<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends CommonController{

    /**
     * 展示登录页
     */
    public function loginAction(){

        //>> 判断是否登录
        if($this->isLogin == 1){

            //>> 已经登录跳转到首页
            return $this->dispatcher->forward([
                'controller'=>'Index',
                'action'=>'index',
            ]);
        }

        $this->view->pick('index/login');

    }

    /**
     * 展示首页
     */
    public function indexAction(){

        //>> 判断是否登录
        if($this->isLogin == 0){

          return  $this->dispatcher->forward([
                'controller'=>'Index',
                'action'=>'login',
            ]);

        }
        $this->view->pick('index/index');

    }

    /**
     * 检测登录
     */
    public function checkAction(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            if(isset($paramArr['username']) && isset($paramArr['password'])){

                $where = [
                    'username'=>$paramArr['username'],
                    'password'=>md5($paramArr['password']),
                ];

                $res = $this->mysql->getOne($where,'*','xm_user');

                if(!empty($res)){

                    //>> 生成token值
                    $session_token = md5('@#$%^'.rand(0,10000).'admin');

                    //>> 将token保存到session中
                    $this->session->set(md5('admin'),$session_token);

                    //>> 将session保存到数据库
                    $sessionData = ['session_token'=>$session_token];

                    $this->mysql->updateData(['id'=>$res['id']],$sessionData,'xm_user');

                    //>> 是否记住个人登录信息
                    if(isset($paramArr['remember']) && $paramArr['remember'] == 1){

                        //>> 生成token值
                        $cookie_token = md5('@#$%^'.rand(0,10000).'remember');

                        //>> 将token值保存到客户端
                        $this->cookies->set(md5('remember'),$cookie_token,time()+24*60*60);

                        $cookieData = ['cookie_token'=>$cookie_token];

                        //>> 将token保存到数据库
                        $this->mysql->updateData(['id'=>$res['id']],$cookieData,'xm_user');
                    }

                    //>> 跳转到首页
                    die($this->common->_printSuccess());

                }else{

                    die($this->common->_printError('10007'));
                }
            }
        }else{

            die($this->common->_printError('10006'));
        }
    }

}