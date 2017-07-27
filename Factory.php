<?php

namespace Liuggio\ExcelBundle;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
     * Create a File Response
     *
     * @param \PHPExcel_Writer_IWriter $writer
     * @param string                   $filename
     * @param int                      $status
     * @param array                    $headers
     *
     * @return BinaryFileResponse
     */
    public function createFileResponse(\PHPExcel_Writer_IWriter $writer, $filename, $status = 200, $headers = array())
    {
        $tempFilename = @tempnam(\PHPExcel_Shared_File::sys_get_temp_dir(), 'phpxlstmp');
        $writer->save($tempFilename);

        $response = new BinaryFileResponse(
            $tempFilename,
            $status,
            $headers
        );

        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
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
