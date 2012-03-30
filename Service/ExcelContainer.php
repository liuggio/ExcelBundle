<?php 

namespace liuggio\ExcelBundle\Service;

class ExcelContainer
{
    public $excelObj;
    protected $factory_class;
    protected $factory_method;
    protected $factory_write_method;
    protected $stream_writer;
    protected $file_type;
    protected $response_class;

    protected $writer; 

    public function __construct($excelObj, $factory_class, $factory_method, $factory_write_method = 'save', $stream_writer, $file_type = 'Excel5', $response_class)
    {
        $this->excelObj = $excelObj;
        $this->factory_class = $factory_class;
        $this->factory_method = $factory_method;
        $this->factory_write_method = $factory_write_method;
        $this->stream_writer = $stream_writer;
        $this->file_type = $file_type;
        $this->response_class = $response_class;
             
    }

    /**
    * This function populate the Writer, calling the factory
    */
    public function createWriter()
    {
        $factory_class = $this->factory_class;
        $factory_method = $this->factory_method;
        $this->writer = $factory_class::$factory_method($this->excelObj, $this->file_type);
        return $this->writer;
    }

    /**
    * This function populate the StreamWriter
    */
    public function createStreamWriter()
    {
        $this->createWriter();
        $this->stream_writer->setWriter($this->writer, $this->factory_write_method);
        return $this->stream_writer;
    }

    /*
    *  create the response with the file content
    */
    public function getResponse()
    {   
        $this->createStreamWriter();
        return new $this->response_class($this->stream_writer);
    }
}