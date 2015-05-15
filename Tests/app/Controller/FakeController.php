<?php

namespace  Liuggio\ExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FakeController extends Controller
{
    public function streamAction()
    {
        // create an empty object
        $phpExcelObject = $this->createXSLObject();
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stream-file.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }

    public function storeAction()
    {
        // create an empty object
        $phpExcelObject = $this->createXSLObject();
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $filename = tempnam(sys_get_temp_dir(), 'xls-') . '.xls';
        // create filename
        $writer->save($filename);

        return new Response($filename, 201);
    }

    public function readAndSaveAction()
    {
        $filename = $this->container->getParameter('xls_fixture_absolute_path');
        // create an object from a filename
        $phpExcelObject = $this->createXSLObject($filename);
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $filename = tempnam(sys_get_temp_dir(), 'xls-') . '.xls';
        // create filename
        $writer->save($filename);

        return new Response($filename, 201);
    }

    /**
     * utility class
     * @return mixed
     */
    private function createXSLObject()
    {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $htmlHelper = $this->get('phpexcel')->createHelperHTML();

        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("Giulio De Donato")
            ->setTitle("Office 2005 XLSX Test Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C3', $htmlHelper->toRichTextObject('<b>In Bold!</b>'));
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        return $phpExcelObject;
    }
}
