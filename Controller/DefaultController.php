<?php

namespace liuggio\ExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        //$xls_service->excelObj =  $this->get('xls.phpexcel');
        $xls_service =  $this->get('xls.service_xls5');

        $xls_service->excelObj->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

		$xls_service->excelObj->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Hello')
		            ->setCellValue('B2', 'world!')
		            ->setCellValue('C1', 'Hello')
		            ->setCellValue('D2', 'world!');

		// Miscellaneous glyphs, UTF-8
		$xls_service->excelObj->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

		// Rename sheet
		//echo date('H:i:s') . " Rename sheet\n";
		$xls_service->excelObj->getActiveSheet()->setTitle('Simple');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$xls_service->excelObj->setActiveSheetIndex(0);
 

        $response = $xls_service->getResponse();
   
        //$writer=$this->get('xls.factory_xls5');
        
 		

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');
        
        return $response;
        
    }
}
