<?php
namespace Multiple\Backend\Models;

use Phalcon\Mvc\Model;

class XmImage extends Model{

    /**
     * ²éÑ¯Í¼Æ¬
     */
    public function imageList(){

        $sql = "SELECT * FROM xm_image WHERE ";
        $sql .= "`type` = 1  ORDER BY create_time desc";

        $imageList = $this->getReadConnection()->fetchAll($sql);

        return $imageList;
}

    /**
     * É¾³ýÍ¼Æ¬
     */
    public function imageDelete($id){

        $sql = "DELETE FROM xm_image WHERE id = {$id} ";

        $res = $this->getWriteConnection()->execute($sql);

        return $res;
    }
}