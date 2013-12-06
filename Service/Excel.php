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

    protected $streamResponseClass;
    protected $streamWriterClass;

    public function __construct(\PHPExcel $excelObj, $writerClass, $streamResponseClass)
    {
        $this->excelObj              = $excelObj;
        $this->streamResponseClass = $streamResponseClass;
        $this->streamWriterClass   = $writerClass;
    }

    public function load($path)
    {
        if(!$this->reader)
            $this->reader = \PHPExcel_IOFactory::createReader($this->type);

        try {
            $this->excelObj = $this->reader->load($path);

            return true;
        } catch (\Exception $e) {
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
        $streamWriter = new $this->streamWriterClass("php://output");
        $streamWriter->setWriter($this->getWriter(),'save');

        return $streamWriter;
    }

    /**
     * Create the response with the file content.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return new $this->streamResponseClass($this->getStreamWriter());
    }

}
