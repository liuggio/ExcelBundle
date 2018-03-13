<?php

namespace Liuggio\ExcelBundle;

use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Factory for PHPExcel objects, StreamedResponse, and PHPExcel_Writer_IWriter.
 *
 * @package Liuggio\ExcelBundle
 */
class Factory
{
    private $phpExcelIO;

    public function __construct($phpExcelIO = '\PHPExcel_IOFactory')
    {
        $this->phpExcelIO = $phpExcelIO;
    }

    /**
     * Creates an empty PHPExcel Object if the filename is empty, otherwise loads the file into the object.
     *
     * @param string $filename
     *
     * @return \PHPExcel
     */
    public function createPHPExcelObject($filename = null)
    {
        return (null === $filename) ? new \PHPExcel() : call_user_func(array($this->phpExcelIO, 'load'), $filename);
    }

    /**
     * Create a worksheet drawing
     * @return \PHPExcel_Worksheet_Drawing
     */
    public function createPHPExcelWorksheetDrawing()
    {
        return new \PHPExcel_Worksheet_Drawing();
    }

    /**
     * Create a reader
     *
     * @param string $type
     *
     *
     * @return \PHPExcel_Reader_IReader
     */
    public function createReader($type = 'Excel5')
    {
        $type = $this->convertType($type);
        return call_user_func(array($this->phpExcelIO, 'createReader'), $type);
    }

    /**
     * Create a writer given the PHPExcelObject and the type,
     *   the type could be one of PHPExcel_IOFactory::$_autoResolveClasses
     *
     * @param \PHPExcel $phpExcelObject
     * @param string $type
     *
     *
     * @return \PHPExcel_Writer_IWriter
     */
    public function createWriter(\PHPExcel $phpExcelObject, $type = 'Excel5')
    {
        $type = $this->convertType($type);
        return call_user_func(array($this->phpExcelIO, 'createWriter'), $phpExcelObject, $type);
    }

    /**
     * Stream the file as Response.
     *
     * @param \PHPExcel_Writer_IWriter $writer
     * @param int                      $status
     * @param array                    $headers
     *
     * @return StreamedResponse
     */
    public function createStreamedResponse(\PHPExcel_Writer_IWriter $writer, $status = 200, $headers = array())
    {
        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $status,
            $headers
        );
    }

    /**
     * Create a PHPExcel Helper HTML Object
     *
     * @return \PHPExcel_Helper_HTML
     */
    public function createHelperHTML()
    {
        return new \PHPExcel_Helper_HTML();
    }

    /**
     * Documentation link: https://phpspreadsheet.readthedocs.io/en/develop/topics/migration-from-PHPExcel/#renamed-readers-and-writers
     *
     * @param string $type
     *
     * @return string
     */
    private function convertType($type)
    {
        switch ($type) {
            case 'CSV':
                return 'Csv';
                break;
            case 'Excel2003XML':
                return 'Xml';
                break;
            case 'Excel2007':
                return 'Xlsx';
                break;
            case 'Excel5':
                return 'Xls';
                break;
            case 'HTML':
                return 'Html';
                break;
            case 'OOCalc':
            case 'OpenDocument':
                return 'Ods';
                break;
            case 'PDF':
                return 'Pdf';
                break;
            case 'SYLK':
                return 'Slk';
                break;
            default:
                return $type;
                break;
        }
    }
}
