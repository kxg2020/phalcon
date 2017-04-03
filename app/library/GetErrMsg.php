<?php
/**
 * 错误信息定义和获取类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/5
 * Time: 15:49
 */

class GetErrMsg
{
    protected $_msgArr = [
        '10000' => ['图片上传失败','图片上传失败'],
        '10001'=>['保存失败','保存到失败'],
        '10002'=>['数组为空','数组为空'],
        '10003'=>['修改失败','修改失败'],
        '10004'=>['删除失败','删除失败'],
        '10005'=>['文章添加失败','文章添加失败'],

    ];


    public function __construct(){}


    /**
     * 获得提示信息
     * @param $errno
     * @param int $isShowMsg
     * @return string
     */
    public function getErrMsg($errno, $isShowMsg = 1)
    {
        /*if($this->config->system->debugModel == 1){
            //开启调试模试后显示真实的错误信息
            $errmsg = $this->_msgArr[$errno][0];
        }else{
            //未开启调试模试显示优化后（对用户友好的）的错误信息
            $errmsg = $this->_msgArr[$errno][1];
        }*/

        $errmsg = $this->_msgArr[$errno][0];
        //是否展示错误信息
        if ($isShowMsg == 0) {
            $msg = ['status'=>0,'errno'=>$errno];
        }else{
            $msg = ['status'=>0,'errno'=>$errno,'errmsg'=>$errmsg];
        }

        return $msg;
    }
}

