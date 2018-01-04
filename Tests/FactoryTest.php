<?php

namespace Liuggio\ExcelBundle\Tests;

use Liuggio\ExcelBundle\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $factory =  new Factory();
        $this->assertInstanceOf('\PHPExcel', $factory->createPHPExcelObject());
    }

    public function testCreateReader()
    {
        $factory =  new Factory();
        $this->assertInstanceOf('\PHPExcel_Reader_IReader', $factory->createReader());
    }

    public function testCreateWriter()
    {
        $factory =  new Factory();
        $this->assertInstanceOf('\PHPExcel_Writer_IWriter', $factory->createWriter($factory->createPHPExcelObject()));
    }

    public function testCreateStreamedResponse()
    {
        $writer = $this->getMockBuilder('\PHPExcel_Writer_IWriter')->getMock();
        $writer->expects($this->once())
            ->method('save')
            ->with('php://output');

        $factory =  new Factory();
        $factory->createStreamedResponse($writer)->sendContent();
    }

    public function testCreateHelperHtml()
    {
        $factory =  new Factory();
        $helperHtml = $factory->createHelperHTML();
        
        $this->assertInstanceOf('\PHPExcel_Helper_HTML', $helperHtml);
    }
}
