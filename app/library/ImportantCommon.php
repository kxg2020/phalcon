<?php
use Phalcon\Mvc\User\Component as Component;

class ImportantCommon extends Component
{
    /**
     * 生成Salt
     * @return string
     */
    public function generateSalt()
    {
        $str = md5('Change Myself!'.microtime());
        return $str;
    }


    /**
     * @param $pwd
     * @param string $salt
     * @return string
     */
    public function encryptPwd($pwd,$salt='')
    {
        if($salt == ''){
           $salt = $this->generateSalt();
        }

        $password = md5(md5($pwd).$salt);

        return $password;
    }


    /**
     * @return string
     */
    public function generateToken()
    {
        return md5(md5('Change Myself!'.microtime()));
    }


    /**
     * 生成随机字串
     * @param number $length 长度，默认为16，最长为32字节
     * @return string
     */
    public function generateNonceStr($length=16){
        // 密码字符集，可任意添加你需要的字符
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i++)
        {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }
}