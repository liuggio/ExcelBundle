<?php

namespace liuggio\ExcelBundle\Service;

/**
 *
 */
class ExcelContainer
{

    /**
     * @var
     */
    public $excelObj;
    /**
     * @var
     */
    protected $factory_writer;
    /**
     * @var
     */
    protected $factory_write_method;
    /**
     * @var
     */
    protected $stream_writer;
    /**
     * @var
     */
    protected $response_service;



    /**
     * @param $excelObj
     * @param $factory_writer
     * @param string $factory_write_method
     * @param $stream_writer
     * @param $response_service
     */
    public function __construct($excelObj, $factory_writer, $factory_write_method = 'save', $stream_writer, $response_service)
    {
        $this->setExcelObj($excelObj);
        $this->setFactoryWriter($factory_writer);
        $this->setFactoryWriteMethod($factory_write_method);
        $this->setStreamWriter($stream_writer);
        $this->setResponseService($response_service);

    }



    /**
     * This function populate the StreamWriter
     * @return streamwriter
     */
    public function createStreamWriter()
    {
        $writer = $this->getFactoryWriter();
        $this->getStreamWriter()->setWriter($writer, $this->getFactoryWriteMethod());
        return $this->getStreamWriter();
    }

    /*
    *  create the response with the file content
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function getResponse()
    {
        $responsiveClass = $this->getResponseService();
        return new $responsiveClass($this->createStreamWriter());
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
     * @param  $factory_class
     */
    public function setFactoryWriter($factory_writer)
    {
        $this->factory_writer = $factory_writer;
    }

    /**
     * @return
     */
    public function getFactoryWriter()
    {
        return $this->factory_writer;
    }

    /**
     * @param  $factory_method
     */
    public function setFactoryMethod($factory_method)
    {
        $this->factory_method = $factory_method;
    }

    /**
     * @return
     */
    public function getFactoryMethod()
    {
        return $this->factory_method;
    }

    /**
     * @param string $factory_write_method
     */
    public function setFactoryWriteMethod($factory_write_method)
    {
        $this->factory_write_method = $factory_write_method;
    }

    /**
     * @return string
     */
    public function getFactoryWriteMethod()
    {
        return $this->factory_write_method;
    }

    /**
     * @param string $file_type
     */
    public function setFileType($file_type)
    {
        $this->file_type = $file_type;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->file_type;
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

    /**
     * @param  $writer
     */
    public function setWriter($writer)
    {
        $this->writer = $writer;
    }

    /**
     * @return
     */
    public function getWriter()
    {
        return $this->writer;
    }
}
