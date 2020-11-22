<?php
require_once 'bms/excel_classes/PHPExcel.php';
require_once 'bms/excel_classes/PHPExcel/IOFactory.php';

class excel_import {
    public function loadHTML($inputFileName) {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
        $objWriter->save("data/tmp/tmp.html");
        $html=file("data/tmp/tmp.html");
        return implode('',$html);
    }
    public function readValue($inputFileName,$worksheet='',$range='') {
        //$inputFileName = 'bms/excel_classes/data.xlsx';
        $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
        //$objReader = new PHPExcel_Reader_Excel2007();
        $worksheetNames = $objReader->listWorksheetNames($inputFileName);
        if(!empty($worksheet)) {
            $ws=$worksheetNames[$worksheet];
        } else {
            $ws=$worksheetNames[0];
        }
        $objPHPExcel = $objReader->load($inputFileName);
        if(empty($range)) {
            $sheetData = $objPHPExcel->getSheetByName($ws)->toArray(null,true,true,true);
        } else {
            $sheetData = $objPHPExcel->getSheetByName($ws)->rangeToArray('A1:H3',null,true,true,true);
        }
        return $sheetData;
    }
    public function readWorkSheet($inputFileName) {
        $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
        $worksheetNames = $objReader->listWorksheetNames($inputFileName);
        return $worksheetNames;
    }
    public function importSKF_cat() {
        require_once 'bms/modules/excel_import.php';
        $excel=new excel_import();
        $data=@$excel->readValue("/home/haidt/phplib/bms/excel_classes/kh.xlsx",0);
        $str='';
        $i=0;
        foreach ($data as $value) {
            $i++;
            if($i<2) {
                continue;
            }
            $str.=(empty($str)?'':',').'(';
            $fields='';
            $j=0;
            foreach ($value as $field) {
                $j++;
                if($j<2||$j>10) {
                    continue;
                }
                $fields.=(empty($fields)?'':',')."'".$field."'";
            }
            $str.=$fields.')';
        }       
        $db->query("insert into skf.skf_categories(cat_no, cat_name,par_id) values".$str);          
    }
    public function importSKF($data) {
        global $db;
        require_once 'bms/modules/excel_import.php';
        $excel=new excel_import();
        $data=@$excel->readValue("/home/haidt/phplib/bms/excel_classes/bearing2.xlsx",0);        
        $str='';
        $i=0;
        foreach ($data as $value) {
            $i++;
            if($i<4) {
                continue;
            }
            $str.=(empty($str)?'':',').'(NULL,';
            $fields='';
            $j=0;
            foreach ($value as $field) {
                $j++;
                if($j<2||$j>10) {
                    continue;
                }
                $fields.=(empty($fields)?'':',')."'".$field."'";
            }
            $str.=$fields.')';
        }
        $db->query("insert into skf.skf_products values".$str);        
    }
}
