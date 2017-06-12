<?php

namespace Liuggio\ExcelBundle\Tests\Controller;

use Liuggio\ExcelBundle\Tests\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FakeControllerTest extends WebTestCase
{
    public function testStreamAction()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/fake/stream');

        $client->getResponse()->sendContent();
        $content = ob_get_contents();
        ob_clean();

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        $this->assertStringStartsWith('attachment;filename=', $client->getResponse()->headers->get('content-disposition'));

        $this->assertNotEmpty($content, 'Response should not be empty');
        $this->assertNotNull($content, 'Response should not be null');
    }

    public function testReaderAction()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/fake/reader');

        $client->getResponse()->sendContent();
        $content = ob_get_contents();
        ob_clean();

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        $this->assertEquals('Hello world!', $client->getResponse()->getContent());

        $this->assertNotEmpty($content, 'Response should not be empty');
        $this->assertNotNull($content, 'Response should not be null');
    }

    public function testSaveAction()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/fake/store');

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

        $content = $client->getResponse()->getContent();

        $this->assertStringEndsWith('.xls', $content);

        $this->assertFileExists($content, sprintf('file %s should exist', $content));
    }

    public function testReadAndSaveAction()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/fake/read');

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

        $content = $client->getResponse()->getContent();

        $this->assertStringEndsWith('.xls', $content);

        $this->assertFileExists($content, sprintf('file %s should exist', $content));
    }

    /**
     * @inheritdoc
     */
    protected static function getKernelClass()
    {
        return AppKernel::class;
    }
}
