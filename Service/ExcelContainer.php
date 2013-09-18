<?php

namespace Liuggio\ExcelBundle\Service;

use n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamResponse;
use n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamWriterWrapper;
use PHPExcel;

/**
 *
 */
class ExcelContainer
{
    /**
     * @var PHPExcel
     */
    public $excelObj;

    /**
     * @var StreamWriterWrapper
     */
    protected $stream_writer;

    /**
     * @var StreamResponse
     */
    protected $response_service;

    /**
     * @param PHPExcel              $excelObj
     * @param StreamWriterWrapper   $stream_writer
     * @param StreamResponse        $response_service
     */
    public function __construct($excelObj, $stream_writer, $response_service)
    {
        $this->setExcelObj($excelObj);
        $this->setStreamWriter($stream_writer);
        $this->setResponseService($response_service);
    }

    /**
     *  create the response with the file content
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        $responsiveClass = $this->getResponseService();
        return new $responsiveClass($this->getStreamWriter());
    }

    /*
     *
     *   Getters and setters
     *
     */

    /**
     * @param $excelObj
     */
    public function setExcelObj($excelObj)
    {
        $this->excelObj = $excelObj;
    }

    /**
     * @return mixed
     */
    public function getExcelObj()
    {
        return $this->excelObj;
    }

    /**
     * @param  $response_service
     */
    public function setResponseService($response_service)
    {
        $this->response_service = $response_service;
    }

    /**
     * @return
     */
    public function getResponseService()
    {
        return $this->response_service;
    }

    /**
     * @param  $stream_writer
     */
    public function setStreamWriter($stream_writer)
    {
        $this->stream_writer = $stream_writer;
    }

    /**
     * @return
     */
    public function getStreamWriter()
    {
        return $this->stream_writer;
    }

}
