<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    /**
     * 展示首页
     */
    public function indexAction(){

<<<<<<< HEAD


        //>> 查询banner图
        $bannerList = $this->mysql->getList(['is_active'=>1],'*','create_time desc','','','xm_image');
=======
        //>> ��ѯbannerͼ
        $where = ['is_banner'=>1];
        $bannerList  = $this->mysql->getList($where,'image_url',' create_time desc,sort asc','','','xm_image');
>>>>>>> f4202f526fd8fb5d158ff01e530565fdd3800578

        $this->view->pick('index/index')->setVars(['list'=>$bannerList['allrow']]);

    }

    public function exampleAction(){





    }

    public function show404Action(){

        echo  "页面没有";
    }
}