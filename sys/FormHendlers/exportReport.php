<?php
require('../../Settings.php');
require('../../autoloader.php');
session_start();
// print_r($_POST);
// echo "xsl Data Here";

if(isset($_POST["submitReport"])) {
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	
	($_SESSION["Tobo"] == 1800) ? $tobo = '0000' : $tobo = $_SESSION["Tobo"];
	
	
	$dataT = explode("/", $post["dateReport"]);
	
	$dataSql = $dataT[2] . "-" . $dataT[1] . "-" . $dataT[0];
	//print_r($dataSql);
	echo $dataSql;
	
	$Report = new Trigger(
		"Subv",
		'select',
		"selectFn",
		array(
			"date"	=> $dataSql,
			"Tobo"	=> $tobo
		)
	);

	$reportData = $Report->get();
	//$repDt = array($post["dateReport"]);
	// print_r($reportData);
	// print_r($post);
	
	// $ReportSummaryImp = new ReportImp();
	
	$xls = new ReportSubTExcel($reportData, $dataT);
	if(class_exists("ReportSubTExcel", true)) {
		// $xls = new ReportSubTExcel($reportData, $repDt, $ReportSummaryImp);
		//$xls = new ReportSubTExcel($reportData, $repDt);
		
		$objWriter = new PHPExcel_Writer_Excel5($xls->setXLSData());
		$objWriter->save($xls->getfileName());
		$xls->getFile($xls->getFilename());
	}
	echo "немає класу звіту у views";
	return;
}


// $objWriter = new PHPExcel_Writer_Excel5($xls->setXLSData());
// $objWriter->save($xls->getfileName());
// $xls->getFile($xls->getFilename());
?>