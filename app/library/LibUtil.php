<?php
use Phalcon\Mvc\User\Component as Component;

class LibUtil extends Component
{

    public function checkUserName($uname)
    {
        if( !$this->validateGeneralString($uname)){
            die($this->common->_printError('10010'));
        }
    }

    /**
     * 验证Email
     * @param $value
     * @return int
     */
    public function validateEmail($value)
    {
        $pattern = "/^([a-z0-9_\-\.]+)@(([a-z0-9]+[_\-]?)\.)+[a-z]{2,3}$/i";
        /*if(preg_match($pattern,$value) == false){
            die($this->common->_printError('10015'));
        }*/
        return preg_match($pattern,$value);
    }

    /**
     * 验证TOKEN
     * @param $value
     * @return int
     */
    public function validateToken($value)
    {
        $pattern = "/^[a-zA-Z0-9]{33,34}$/";
        return preg_match($pattern,$value);
    }


    /**
     * 验证年龄
     * @param $value
     * @return int
     */
    public function validateAge($value)
    {
        $pattern = "/^[1-9][0-9]*|0$/";
        return preg_match($pattern,$value);
    }

    /**
     * 验证手机号码
     * @param $value
     * @return int
     */
    public function validateMobile($value)
    {
        $pattern = "/^(13|14|15|17|18)[0-9]{9}$/";
        return preg_match($pattern, $value);
    }

    /**
     * 验证密码长度
     * @param $value
     * @param int $long
     * @return int
     */
    public function validatePwd($value,$long=18)
    {
        $pattern = "/^.{6,$long}$/";
        return  preg_match($pattern,$value);
    }

    /**
     * 验证身份证号码
     * @param $value
     * @return int
     */
    public function validateICNO($value)
    {
        //$pattern = "/^(([1-9][0-9]{17})|([1-9][0-9]{16}[xX]))$/";
        $upper_value = strtoupper($value);
        $pattern = "/(1[1-5]|2[1-3]|3[1-7]|4[1-6]|5[0-4]|6[1-5]|71|81|82|90)([0-5][0-9]|90)(\d{2})(19|20)(\d{2})((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))(\d{3})([0-9]|X)/";
        return preg_match($pattern,$upper_value);
    }

    /**
     * 验证浮点数
     * @param $value
     * @return int
     */
    public function validateFloat($value)
    {
        $pattern = "/^\d{1,9}(\.\d{1,2})?$/";
        return preg_match($pattern,$value);
    }


    /**
     * 无符号整数
     * @param $value
     * @return int
     */
    public function validateUnsignInt($value)
    {
        $pattern = "/^[1-9][0-9]*/";
        return preg_match($pattern,$value);
    }

    /**
     * @param $value
     * @return int
     */
    public function validateLocation($value)
    {
        $pattern = "/^-?(\d|[1-9]\d|1[0-7]\d).(\d{1,9}),\040*-?(\d|[1-8]\d).(\d{1,9})$/"; #37.480563, 121.467113 - lat,lng
        return preg_match($pattern, $value);
    }

    public function validateGeneralString($value)
    {
        $pattern = "/^[1-9a-z][a-z0-9_]*/";
        return preg_match($pattern,$value);
    }
}