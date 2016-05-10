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
     * Create a writer given the PHPExcelObject and the type,
     *   the type coul be one of PHPExcel_IOFactory::$_autoResolveClasses
     *
     * @param \PHPExcel $phpExcelObject
     * @param string    $type
     *
     *
     * @return \PHPExcel_Writer_IWriter
     */
    public function createWriter(\PHPExcel $phpExcelObject, $type = 'Excel5')
    {
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
}
