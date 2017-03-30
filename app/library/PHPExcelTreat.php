<?php
require_once ROOT_PATH.'app/library/PHPExcel/Classes/PHPExcel.php';
use Phalcon\Http\Response as Response;

class PHPExcelTreat extends Phalcon\Mvc\User\Component
{

    /**
     * 导出数据到EXCEL
     * @param $data
     * @param string $fileName
     * @param string $title
     * @return Response
     * @throws PHPExcel_Exception
     */
    public function exportDataToExcel($data,$fileName='',$title='')
    {
        $objPHPExcel = new PHPExcel();

        //设置文件属性
        $objPHPExcel->getProperties()->setCreator("System Auto")
            ->setLastModifiedBy("System Auto")
            ->setTitle($title)
            ->setSubject("Excel File")
            ->setDescription("Excel File")
            ->setKeywords("office Excel")
            ->setCategory("Excel");

        $starChar = 'A';

        //输出表头（字段名）
        foreach($data[0] as $columnNum => $columnName){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($starChar, $columnName);
            $starChar++;
        }

        //删除表头
        unset($data[0]);

        //输出内容
        foreach($data as $rowItem){
            $starChar = 'A';
            foreach($rowItem as $columnNum =>$columnValue){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($starChar.($columnNum+1), $columnValue);
                $starChar++;
            }
        }

        $objPHPExcel->setActiveSheetIndex(0);

        //设置文件名
        if($fileName == ''){
            $fileName = date("Ymd_his") . ".xls";
        }

        $temp_file = tempnam(sys_get_temp_dir(), 'phpexcel');

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save($temp_file);

        $response = new Response();

        // Redirect output to a client’s web browser (Excel2005)
        $response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setHeader('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->setHeader('Cache-Control', 'max-age=0');

        // If you're serving to IE 9, then the following may be needed
        $response->setHeader('Cache-Control', 'max-age=1');

        //Set the content of the response
        $response->setContent(file_get_contents($temp_file));

        // delete temp file
        unlink($temp_file);

        //Return the response
        return $response;
    }


    /**
     * Excel表格转换成数组
     * @param $filePath
     * @param $ext
     * @return array|bool
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public function excelToArray($filePath,$ext)
    {

        if($ext == 'xls'){
            $PHPReader = new PHPExcel_Reader_Excel5();
        }elseif($ext == 'xlsx' || $ext == 'xlsm'){
            $PHPReader = new PHPExcel_Reader_Excel2007();
        }else{
            return false;
        }

        if (!$PHPReader->canRead($filePath)) {
            return false;
        }


        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB<br>";

        $currentSheet = $objPHPExcel->getSheet(0);
        $allColumn = $currentSheet->getHighestColumn();
        $allRow = $currentSheet->getHighestRow();

        $sheetData = array();
        $columnData= array();

        for($currentRow = 2;$currentRow<=$allRow;$currentRow++){
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //保存一行的数据
                $columnData[] = $currentSheet->getCell($currentColumn.$currentRow)->getValue();
            }

            //保存表数据
            $sheetData[] = $columnData;
        }

        return $sheetData;
    }

}