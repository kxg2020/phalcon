<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class CommonController extends Controller{

    public $isLogin = 0;

    public $userInfo = [];
    /**
     * 检测用户是否登录
     */
    public function  _construct(){

        //>> 获取session
        $session = $this->session->get(md5('admin'));

        if(!empty($session)){

            //>> 根据session查询数据库
            $where = ['session_token'=>$session];
            $row = $this->mysql->getOne($where,'*','xm_user');

            if(!empty($row)){

                //>> 将属性重新赋值
                $this->isLogin = 1;
                $this->userInfo = $row;
                $this->view->setVars(['userInfo'=>$this->userInfo]);
            }
        }else{

            //>> 获取cookie
            $cookie = $this->cookies->get(md5('remember'));

            if(!empty($cookie)){

                //>> 根据cookie查询数据库
                $where = ['cookie_token'=>$cookie];
                $res = $this->mysql->getOne($where,'*','xm_user');
                if(!empty($res)){
                    $this->isLogin = 1;
                    $this->userInfo = $res;
                    $this->view->setVars(['userInfo'=>$this->userInfo]);
                }
            }
        }
    }
}