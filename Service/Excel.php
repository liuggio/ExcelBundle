<?php

namespace Liuggio\ExcelBundle\Service;

/**
 * Description of Excel
 *
 * @author gnat
 */
class Excel
{
    public $excelObj;

    private $type;

    private $reader;
    private $writer;
    private $types = array('Excel5','Excel2007','PDF');

    protected $stream_response_class;
    protected $stream_writer_class;

    public function __construct(\PHPExcel $excelObj, $writer_class, $stream_response_class)
    {
        $this->excelObj              = $excelObj;
        $this->stream_response_class = $stream_response_class;
        $this->stream_writer_class   = $writer_class;
    }
    
    public function load($path)
    {
        if(!$this->reader)
            $this->reader = \PHPExcel_IOFactory::createReader($this->type);
        
        try 
        {
            $this->excelObj = $this->reader->load($path);
            return true;
        }
        catch(\Exception $e)
        {
            return false;
        }
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if(!in_array($type, $this->types))
            throw new \InvalidArgumentException();
        
        $this->type = $type;
        
        return $this;
    }

    public function getWriter($type = null)
    {
        if(!is_null($type))
            $this->setType($type);

        $this->writer = \PHPExcel_IOFactory::createWriter($this->excelObj, $this->type);
        
        return $this->writer;
    }
    
    public function getStreamWriter()
    {
        $stream_writer = new $this->stream_writer_class("php://output");
        $stream_writer->setWriter($this->getWriter(),'save');
        
        return $stream_writer;
    }

    /**
     *  create the response with the file content
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return new $this->stream_response_class($this->getStreamWriter());
    }

}
