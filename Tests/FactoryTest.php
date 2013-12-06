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

    public function testCreateStreamedResponse()
    {
        $writer = $this->getMock('\PHPExcel_Writer_IWriter');
        $writer->expects($this->once())
            ->method('save')
            ->with('php://output');

        $factory =  new Factory();
        $factory->createStreamedResponse($writer)->sendContent();
    }
}
