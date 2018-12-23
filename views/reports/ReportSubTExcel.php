<?php
class ReportSubTExcel 
{
	public $data;
	public $dt;
    public $xls;
    public $filename;
	
	// public function __construct($data, $dt , IReport $Imp) {
	public function __construct($data, $dt) {
		// echo "<pre>";
		// print_r($data);
		//echo "</pre>";
		$this->dt = $dt;
		//print_r ($this->dt); 
		$this->filename = Settings::$FILES_TEMP . "Report1.xls";
		$xls =  new PHPExcel();
		$xls->setActiveSheetIndex(0);
		$xls->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);
		$this->xls = $xls;
		$this->data = $data;
		
		
		$this->setXLSData();
	}
	
	public function getFilename() {
		return $this->filename;
	}
	
	public function getXLSHead($caps, $sheet_names) {
	}
	
	public function setXLSData() {
		if($this->data == null){
			return $this->xls;
		} else {
			$max_string_lenght = 0;
			$k = 0;
			
			(strlen($this->dt[1]) <= 1) 
			? $month = "0" . $this->dt[1] 
			: $month = $this->dt[1];

			(strlen($this->dt[0]) <= 1) 
			? $den = "0" . $this->dt[0] 
			: $den = $this->dt[0];
			
			$Dat1 = new DateTime($this->dt[0].'-'.$month.'-'.$den);
		    $Dat1->modify("-1 day");
			$Dat1 = $Dat1->format('d/m/y');
            $month1 = substr($Dat1,3,2);
            $month2 = $this->getMes2($month1);			
			
			$sheet = $this->xls->setActiveSheetIndex(0);
			$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$sheet->getPageMargins()->setTop(0.2);
			$sheet->getPageMargins()->setRight(0.2);
			$sheet->getPageMargins()->setLeft(0.2);
			$sheet->getPageMargins()->setBottom(0.2);
			$sheet->getColumnDimension('A')->setWidth(8); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(80); 
			$sheet->getColumnDimension('D')->setWidth(16); 
			$sheet->getColumnDimension('E')->setWidth(16); 
			$sheet->getColumnDimension('F')->setWidth(16);
			$sheet->getColumnDimension('G')->setWidth(16);
			$sheet->getColumnDimension('H')->setWidth(16);
			
			$sheet->mergeCells('A3:H3');
			$sheet->mergeCells('B4:G4');
			$sheet->mergeCells('A5:H5');
			$sheet->mergeCells('A6:H6');
			
			$sheet->mergeCells('A8:A10');
			$sheet->mergeCells('B8:B10');
			$sheet->mergeCells('C8:C10');
			$sheet->mergeCells('D8:E8');
			$sheet->mergeCells('F8:G8');
			$sheet->mergeCells('D9:D10');
			$sheet->mergeCells('E9:E10');
			$sheet->mergeCells('H8:H10');
			$sheet->mergeCells('F9:F10');
			$sheet->mergeCells('G9:G10');

			
			$sheet->getStyle("A8:H11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$sheet->getStyle("A8:H11")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A8:H11")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//$sheet->getStyle('A1:H12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle("A1:H11")->getFont()->setBold(true);
			$sheet->getStyle('A1:H11')->getAlignment()->setWrapText(true);
			
			
			$sheet->mergeCells('A11:H11');
			
			$sheet->setCellValue('A11', "Сумська область");
			$sheet->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$sheet->setCellValue('A3', "ІНФОРМАЦІЯ");
			$sheet->getRowDimension('4')->setRowHeight(50);
			$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$sheet->setCellValue('G1',"Додаток 1");
			$sheet->getStyle('G1')->getFont()->setName('Arial')->setSize(5);
			$sheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->setCellValue('H7',"грн.");
			$sheet->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$sheet->setCellValue('B4',"щодо надання у {$this->dt[2]} році та використання субвенції з державного бюджету місцевим бюджетам на здійснення заходів щодо соціально-економічного розвитку окремих територій, передбаченої постановою Кабінету Міністрів України від 06.02.2012 №106 (зі змінами)");
			$sheet->getStyle('B4')->getAlignment()->setWrapText(true);
			
			$sheet->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$sheet->getStyle('B4')->getFont()->setName('Arial')->setSize(10);
			
			$sheet->setCellValue('A5', "по Сумській області");
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->setCellValue('A6', "станом на ".$den.$this->getMes1($month).$this->dt[2]." року");
			$sheet->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$sheet->setCellValue('A8', "№ з/п");
			$sheet->setCellValue('B8', "Одержувач субвенції, адміністративно-територіальна одиниця");
			$sheet->setCellValue('C8', "Назва об'єкту, заходу ");
			$sheet->setCellValue('D8', "Передбачено розписом");
			$sheet->setCellValue('F8', "Фактично перераховано");
			$sheet->setCellValue('H8', "Касові видатки місцевого бюджету");
			$sheet->setCellValue('D9', "на рік");
			$sheet->setCellValue('E9', "на січень -".$month2);
			$sheet->setCellValue('F9', "всього");
			$sheet->setCellValue('G9', "за ".$month2);
			
			
			$sheet->getRowDimension('8')->setRowHeight(25);
			$sheet->getRowDimension('9')->setRowHeight(25);
			$sheet->getRowDimension('10')->setRowHeight(25);
			$sheet->getStyle('A8:H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('A8:H8')->getAlignment()->setWrapText(true);
			
			$numTotal = 0;
			$total = array();
			//12 amount of rows in doc header
			$i = 12;
			$k = 0;
			$l = null;
			while(!is_null($st = array_shift($this->data))) {
				// echo "<pre>";
				//print_r($st);
				if($st["ObjName"] == "Total") {
					$total = $st;
					continue;
				}
				if($st["ObjName"] === "TotalBudg") {
					$k++;
					$l = 1;
					$st["ObjName"] = "Всього:";
					$sheet->getRowDimension($i)->setRowHeight(35);
					$sheet->getStyle("A".$i . ":H" . $i)->getFont()->setBold(true);
					
					$sheet->getStyle("A".$i.":H".$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					
					$sheet->getStyle("C". $i )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					
					$sheet->getStyle("A" . $i.":B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$sheet->getStyle("D".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$sheet->getStyle("D".$i.":H".$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        		//	$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		        	$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setWrapText(true);
					
					$sheet->setCellValue("A".$i, $k);
					$sheet->setCellValue("B".$i, $st["budgName"]);
					$sheet->setCellValue("C".$i, $st["ObjName"]);
					$sheet->setCellValue("D".$i, $st["SumYear"]);
					$sheet->setCellValue("E".$i, $st["SumProv"]);
					$sheet->setCellValue("F".$i, $st["FactSum"]);
					$sheet->setCellValue("G".$i, $st["Fact"]);
					$sheet->setCellValue("H".$i, $st["OutSum"]);
					$i++;
					continue;
				}
				
				
				// print_r($st);	
				$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setWrapText(true);
				$sheet->getRowDimension($i)->setRowHeight(35);
				$sheet->getStyle("A".$i.":H".$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$sheet->getStyle("C". $i )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$sheet->getStyle("A" . $i.":B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("D".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$sheet->getStyle("D".$i.":H".$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				
				$sheet->setCellValue("A".$i, "{$k}".". {$l}");
				$sheet->setCellValue("B".$i, $st["budgName"]);
				$sheet->setCellValue("C".$i, $st["ObjName"]);
				$sheet->setCellValue("D".$i, $st["SumYear"]);
				$sheet->setCellValue("E".$i, $st["SumProv"]);
				$sheet->setCellValue("F".$i, $st["FactSum"]);
				$sheet->setCellValue("G".$i, $st["Fact"]);
				$sheet->setCellValue("H".$i, $st["OutSum"]);
				
				$l++;
				$i++;
			}
			$sheet->getStyle("D".$i.":H".$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setWrapText(true);
			$sheet->getRowDimension($i)->setRowHeight(35);
			$sheet->getStyle("A".$i.":H".$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A".$i.":H".$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$sheet->getStyle("A".$i)->getFont()->setBold(true);
			$sheet->getStyle("B".$i)->getFont()->setBold(true);
			$sheet->getStyle("D".$i)->getFont()->setBold(true);
			$sheet->getStyle("E".$i)->getFont()->setBold(true);
			$sheet->getStyle("F".$i)->getFont()->setBold(true);
			$sheet->getStyle("G".$i)->getFont()->setBold(true);
			$sheet->getStyle("H".$i)->getFont()->setBold(true);
			
			$sheet->setCellValue("A".$i, "");
			$sheet->setCellValue("B".$i, "Всього по Сумській області");
			$sheet->setCellValue("C".$i, "");
			$sheet->setCellValue("D".$i, $total["SumYear"]);
			$sheet->setCellValue("E".$i, $total["SumProv"]);
			$sheet->setCellValue("F".$i, $total["FactSum"]);
			$sheet->setCellValue("G".$i, $total["FactSum"]);
			$sheet->setCellValue("H".$i, $total["OutSum"]);
			//END write Total SUM
			
			
			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			
			$sheet->mergeCells("A" . ($i+2) . ":B" . ($i+2));
			$sheet->setCellValue("A" . ($i +2), "Начальник");
			$sheet->getStyle("A". ($i +2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$sheet->setCellValue("C" . ($i + 2), "___________");
			$sheet->setCellValue("F" . ($i + 2), "О.В. Лісовий");
			$sheet->getStyle("F" . ($i +2))->getFont()->setBold(true);
			$sheet->getStyle("F". ($i +2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$sheet->setCellValue("C" . ($i + 3), "(підпис)");
			$sheet->setCellValue("F" . ($i + 3), "(ініціали та прізвище)");
			
			
			$sheet->setCellValue("A" . ($i + 4), "Виконавець: Ірина Прощенко");
			
			
			$sheet->getPageSetup()->setPrintArea('A1:H' . ($i+5));
			//$sheet->fromArray($this->data,'null',"A3");
			return $this->xls;
		}
	}
	
	private function getMes2($mes) {
   		 switch ($mes){
		case "02":
			 $Mes2 = ' лютий';
			 break;	
		case "03":
			 $Mes2 = ' березень ';
			 break;
		case "04":
			 $Mes2 = ' квітень ';
			 break;
		case "05":
			 $Mes2 = ' травень ';
			 break;
		case "06":
			 $Mes2 = ' червень ';
			 break;
		case "07":
			 $Mes2 = ' липень ';
			 break;
		case "08":
			 $Mes2 = ' серпень ';
			 break;
		case "09":
			 $Mes2 = ' вересень ';
			 break;
		case "10":
			 $Mes2 = ' жовтень ';
			 break;
		case "11":
			 $Mes2 = ' листопад ';
			 break;
		case "12":
			 $Mes2 = ' грудень ';
			 break;
        default:			 
			 $Mes2 = ' січень ';
			 }
   return $Mes2;			 
 }	
	
	private function getMes1($mes) {
   		 switch ($mes){
		case "02":
			 $Mes2 = ' лютого';
			 break;	
		case "03":
			 $Mes2 = ' березня ';
			 break;
		case "04":
			 $Mes2 = ' квітня ';
			 break;
		case "05":
			 $Mes2 = ' травня ';
			 break;
		case "06":
			 $Mes2 = ' червня ';
			 break;
		case "07":
			 $Mes2 = ' липня ';
			 break;
		case "08":
			 $Mes2 = ' серпня ';
			 break;
		case "09":
			 $Mes2 = ' вересня ';
			 break;
		case "10":
			 $Mes2 = ' жовтня ';
			 break;
		case "11":
			 $Mes2 = ' листопада ';
			 break;
		case "12":
			 $Mes2 = ' грудня ';
			 break;
        default:			 
			 $Mes2 = ' січня ';
			 }
   return $Mes2;			 
 }	
	
	
	public  function convert_to_Number($dest)
    {
        if ($dest)
            return ord(strtolower($dest)) - 96;
        else
            return 0;
    }
        
    public  function convert_to_Char($pos) 
    {
        $letter = strtolower(chr($pos + 65));
        return $letter;
    }
	
	public function getFile($file){
        if (file_exists($file)) {
		// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
		// если этого не сделать файл будет читаться в память полностью!
		if (ob_get_level()) {
		  ob_end_clean();
		}
		// заставляем браузер показать окно сохранения файла
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
		unlink($file);
		
		exit;
		} 
    }
}
?>