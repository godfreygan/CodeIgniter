<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * XLSX读取和导出操作
 */
ini_set('memory_limit', '100M'); 
header("Content-type: text/html;charset=utf-8");
class Excels
{
	private $_ci;
	private $data = array();
	private $title = array();

	public function __construct()
    {
		
	 	$_ci =& get_instance();
		$_ci->load->library('Phpexcel');
		$_ci->load->library('PHPExcel/Iofactory.php');	
    }	
	
	//读取XLXS生成数组
	function read_xlsx($file_path)
	{			
		try 
		{
			$objPHPExcel = IOFactory::load($file_path);
		}
		catch(Exception $e)
		{
			die('Error loading file "'.pathinfo($file_path,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
			
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		return $sheetData;
	}

	
	
	// 接收 数据数组 输出
	public function exports($data,$title)
	{
		$objPHPExcel = new PHPExcel();
		$this->data = $data;
		$this->title = $title;

		//设置属性
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                     ->setLastModifiedBy("Maarten Balliauw")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");

									
								    $objPHPExcel->getActiveSheet()->fromArray($this->title, NULL, 'A1');

									/*---------------------对应栏目数据，取数据循环填充-----------------------*/

								    $objPHPExcel->getActiveSheet()->fromArray($this->data, NULL, 'A2');
									

								
									/*---------------------设置列的宽度-----------------------
				
									$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
									$objPHPExcel->getActiveSheet() ->getColumnDimension('B')->setWidth(16);
									$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
									$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
									$objPHPExcel->getActiveSheet()->getColumnDimension('e')->setWidth(16);
									$objPHPExcel->getActiveSheet()->getColumnDimension('f')->setWidth(15);
									$objPHPExcel->getActiveSheet()->getColumnDimension('g')->setWidth(16);
									$objPHPExcel->getActiveSheet()->getColumnDimension('h')->setWidth(16);
									$objPHPExcel->getActiveSheet()->getColumnDimension('i')->setWidth(16);
									$objPHPExcel->getActiveSheet()->getColumnDimension('j')->setWidth(16);
									$objPHPExcel->getActiveSheet()->getColumnDimension('k')->setWidth(16);
									*/

								    // 设置字体
									//$objPHPExcel->getActiveSheet()->getStyle( 'A1:k1')->applyFromArray(
									 //array(
										//   'font'    => array ('bold' => true)
										//)
									//);
									// 字体大小
									//$objPHPExcel->getActiveSheet()->getStyle( 'A1:k1')->getFont()->setSize(14);
									
									// 栏目背景颜色 
									//$objPHPExcel->getActiveSheet()->getStyle( 'A1:k1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
									//$objPHPExcel->getActiveSheet()->getStyle( 'A1:k1')->getFill()->getStartColor()->setARGB('rsssdff');
					
									// 文字居中
									//$objStyleA1 = $objPHPExcel->getActiveSheet()->getStyle('A1:k100'); 							 
									//$objAlignA1 = $objStyleA1->getAlignment();   
									//$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中   
									//$objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中  
								    //$objPHPExcel->getActiveSheet()->setTitle('Simple');
 
		// 清除缓冲 edit by aniu
		if (count(ob_list_handlers()) > 0)
		{
		    @ob_clean();
		}
		 
        //操作句柄 输出文件
        $objPHPExcel->setActiveSheetIndex(0);
        $name = date("Y-m-d H:i");
        $name .= "-product.xlsx";
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');  
		header('Pragma:public');
		header('Content-Type:application/x-msexecl;name="'.$name.'"');
		header('Content-Disposition:inline;filename="'.$name.'"');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
		exit;
	}
	
	//清单
	public function qdexcel($data)
	{
		if($data)
		{
			$objPHPExcel = new PHPExcel();
			//设置属性
			$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
										 ->setLastModifiedBy("Maarten Balliauw")
										 ->setTitle("Office 2007 XLSX Test Document")
										 ->setSubject("Office 2007 XLSX Test Document")
										 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Test result file");										
									
	 
			// 清除缓冲 edit by aniu
			if (count(ob_list_handlers()) > 0)
			{
				@ob_clean();
			}
			
			//操作句柄 输出文件
			//$objPHPExcel->setActiveSheetIndex(0);			
			
			$k=0;
			foreach($data as $v)
			{
				if($v['data'])
				{					
					$objPHPExcel->createSheet();
					$objPHPExcel->getSheet($k)->setTitle($v['spacename']);		
					$objPHPExcel->setActiveSheetIndex($k);					
					$k++;			
					
					$this->kkk=1;
					
					foreach($v['data'] as $k2=>$v2)
					{
						
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$this->kkk, $v2['catename']);
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$this->kkk.':K'.$this->kkk);//合并
						$objPHPExcel->getActiveSheet()->getStyle('A'.$this->kkk)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$this->kkk)->getFill()->getStartColor()->setARGB('ffeb9c');
						
						$this->kkk++;	
						$objPHPExcel->getActiveSheet()->setCellValue('A'.($this->kkk), '图片');			
						//$objPHPExcel->getActiveSheet()->setCellValue('B'.($this->kkk), '产品ID');
						$objPHPExcel->getActiveSheet()->setCellValue('C'.($this->kkk), '产品名称');
						$objPHPExcel->getActiveSheet()->setCellValue('D'.($this->kkk), '产品编号');
						$objPHPExcel->getActiveSheet()->setCellValue('E'.($this->kkk), '品类名称');
						$objPHPExcel->getActiveSheet()->setCellValue('F'.($this->kkk), '规格');
						$objPHPExcel->getActiveSheet()->setCellValue('G'.($this->kkk), '材质');
						$objPHPExcel->getActiveSheet()->setCellValue('H'.($this->kkk), '颜色');
						$objPHPExcel->getActiveSheet()->setCellValue('I'.($this->kkk), '价格');
						$objPHPExcel->getActiveSheet()->setCellValue('J'.($this->kkk), '数量');
						$objPHPExcel->getActiveSheet()->setCellValue('K'.($this->kkk), '小计');
						
						if($v2['data'])
						{								
							foreach($v2['data'] as $k3=>$v3)
							{
								if(isset($v3['id']) && isset($v3['productsn']))
								{																			
									$this->kkk++;
									$objPHPExcel->getActiveSheet()->getRowDimension($this->kkk)->setRowHeight(40);		
									if(file_exists($v3['pic']))
									{													
										$objDrawing = new PHPExcel_Worksheet_Drawing();
										$objDrawing->setName('image');
										$objDrawing->setDescription('image');
										$objDrawing->setPath('./'.$v3['pic']);//.$v3['image'].$v3['thumb200']
										$objDrawing->setResizeProportional(false);
										$objDrawing->setHeight(40);
										$objDrawing->setWidth(40);
										$objDrawing->setCoordinates('A'.$this->kkk);
										$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());		
									}
									else
									{
										$objPHPExcel->getActiveSheet()->setCellValue('A'.($this->kkk), '-');
									}
									
									
									//$objPHPExcel->getActiveSheet()->setCellValue('B'.($this->kkk), $v3['id']);
									$objPHPExcel->getActiveSheet()->setCellValue('C'.($this->kkk), $v3['productname']);
									$objPHPExcel->getActiveSheet()->setCellValue('D'.($this->kkk), $v3['productsn']);
									$objPHPExcel->getActiveSheet()->setCellValue('E'.($this->kkk), $v3['pinglei']);
									$objPHPExcel->getActiveSheet()->setCellValue('F'.($this->kkk), $v3['size']);
									$objPHPExcel->getActiveSheet()->setCellValue('G'.($this->kkk), $v3['material']);
									$objPHPExcel->getActiveSheet()->setCellValue('H'.($this->kkk), $v3['color']);
									$objPHPExcel->getActiveSheet()->setCellValue('I'.($this->kkk), $v3['price']);
									$objPHPExcel->getActiveSheet()->setCellValue('J'.($this->kkk), $v3['count']);
									$objPHPExcel->getActiveSheet()->setCellValue('K'.($this->kkk), '=I'.$this->kkk.'*J'.$this->kkk);
								}
								else
								{
									echo '清单的JSON格式不正确';
									exit;
								}
							}				
						}
						
						$this->kkk = $this->kkk+1;												
					}
					
					$objPHPExcel->getActiveSheet()->setCellValue('I'.($this->kkk), '合计');
					$objPHPExcel->getActiveSheet()->setCellValue('J'.($this->kkk), '=SUM(J1:J'.($this->kkk-1).')');
					$objPHPExcel->getActiveSheet()->setCellValue('K'.($this->kkk), '=SUM(K1:K'.($this->kkk-1).')');	
					$objPHPExcel->getActiveSheet()->getStyle('I'.$this->kkk)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$this->kkk)->getFill()->getStartColor()->setARGB('c6efce');
					$objPHPExcel->getActiveSheet()->getStyle('J'.$this->kkk)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('J'.$this->kkk)->getFill()->getStartColor()->setARGB('c6efce');
					$objPHPExcel->getActiveSheet()->getStyle('K'.$this->kkk)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('K'.$this->kkk)->getFill()->getStartColor()->setARGB('c6efce');		
				}	
			}			
			
			$name = date("Y-m-d H:i");
			$name .= "-product.xlsx";
			header('Content-Type: application/vnd.ms-excel; charset=utf-8');  
			header('Pragma:public');
			header('Content-Type:application/x-msexecl;name="'.$name.'"');
			header('Content-Disposition:inline;filename="'.$name.'"');
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			
		}
		exit;
	}
		
}