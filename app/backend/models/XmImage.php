<?php
namespace Multiple\Backend\Models;

use Phalcon\Mvc\Model;

class XmImage extends Model{

    /**
     * ��ѯͼƬ
     */
    public function imageList(){

        $sql = "SELECT * FROM xm_image WHERE";
        $sql .= "`type` = 1";

        $imageList = $this->getReadConnection()->fetchAll($sql);
        return $imageList;
}

    /**
     * ɾ��ͼƬ
     */
    public function imageDelete($id){

        $sql = "DELETE FROM xm_image WHERE id = {$id} ";

        $res = $this->getWriteConnection()->query($sql);

        return $res;
    }
}