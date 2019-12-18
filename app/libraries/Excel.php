<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel
{
	public function __construct()
	{
		header("Content-type: text/html; charset=utf-8");
		set_time_limit(90); 
		ini_set("memory_limit", "1024M");
		require_once 'PHPExcel/PHPExcel.php';
		require_once 'PHPExcel/PHPExcel/Iofactory.php';
		//require_once 'PHPExcel/PHPExcel/Reader/Excel5.php';
	}
	
	public function standard_import($excel_file)
	{
		$objPHPExcel = PHPExcel_IOFactory::load($excel_file);
		$sheet_count = $objPHPExcel->getSheetCount();
		for ($m = 0; $m < $sheet_count; $m++)
		{
			$currentSheet = $objPHPExcel->getSheet($m);
			$row_number = $currentSheet->getHighestRow();
			$column_max = $currentSheet->getHighestColumn();
			$tempData = array();
			for($i = 2; $i <= $row_number; $i++)
			{
				for($j = 'A'; $j <= $column_max; $j++)
				{
					$coordinate = $j . $i;
					$tempData[$i][] = $currentSheet->getCell($coordinate)->getFormattedValue();
				}
			}
			return $tempData;
		}
	}
}