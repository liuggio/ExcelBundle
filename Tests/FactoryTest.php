<?php

namespace Liuggio\ExcelBundle\Tests;

use Liuggio\ExcelBundle\Factory;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $writer = $this->getMock('\PHPExcel_Writer_IWriter');
        $writer->expects($this->once())
            ->method('save')
            ->with('php://output');

        $factory =  new Factory();
        $factory->createStreamedResponse($writer)->sendContent();
    }

    public function testCreateFileResponse()
    {
        $filename = 'testfilename';
        /** @var ObjectProphecy|\PHPExcel_Writer_IWriter $writer */
        $writer = $this->prophesize('\PHPExcel_Writer_IWriter');
        $writer->save(Argument::type('string'))->shouldBeCalled();

        $factory =  new Factory();
        $response = $factory->createFileResponse($writer->reveal(), $filename);
        
        $this->assertNotEmpty($response->getFile());
        $headers = $response->headers;
        $this->assertStringStartsWith('text/vnd.ms-excel', $headers->get('Content-Type'));
        $this->assertEquals('public', $headers->get('Pragma'));
        $this->assertStringStartsWith('attachment; filename=', $headers->get('content-disposition'));
    }

    public function testCreateHelperHtml()
    {
        $factory =  new Factory();
        $helperHtml = $factory->createHelperHTML();
        
        $this->assertInstanceOf('\PHPExcel_Helper_HTML', $helperHtml);
    }
}
