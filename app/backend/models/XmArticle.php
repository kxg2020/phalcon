<?php
namespace Multiple\Backend\Models;

use Phalcon\Mvc\Model;

class XmArticle extends Model{

    /**
     * ɾ������
     */
    public function articleDelete($id){

        $sql = "DELETE FROM xm_article WHERE id = {$id} ";

        $res = $this->getWriteConnection()->execute($sql);

        return $res;
    }
}