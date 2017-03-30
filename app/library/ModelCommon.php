<?php
use Phalcon\Mvc\User\Component as Component;


class ModelCommon extends Component
{
    public function tableNameFormaToCamelCase($tableName)
    {
        $tempArr = explode('_',$tableName);
        $tableNameStr = '';
        foreach($tempArr as $world){
            $tableNameStr .= ucfirst($world);
        }

        return $tableNameStr;
    }
}