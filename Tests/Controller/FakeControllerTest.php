<?php

namespace Liuggio\ExcelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FakeControllerTest extends WebTestCase
{
    public function testStreamAction()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/stream');

        $client->getResponse()->sendContent();
        $content = ob_get_contents();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        $this->assertStringStartsWith('attachment;filename=', $client->getResponse()->headers->get('content-disposition'));

        $this->assertNotEmpty($content, 'Response should not be empty');
        $this->assertNotNull($content, 'Response should not be null');
    }

    public function testSaveAction()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/store');

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

        $content = $client->getResponse()->getContent();

        $this->assertStringEndsWith('.xls', $content);

        $this->assertFileExists($content, sprintf('file %s should exist', $content));
    }

    public function testReadAndSaveAction()
    {
        $client = static::createClient();

        $client->request('GET', '/fake/read');

        $this->assertEquals(201, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

        $content = $client->getResponse()->getContent();

        $this->assertStringEndsWith('.xls', $content);

        $this->assertFileExists($content, sprintf('file %s should exist', $content));
    }
}
