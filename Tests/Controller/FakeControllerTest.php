<?php

namespace Liuggio\ExcelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FakeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/fake');

        ob_start();
        $client->getResponse()->sendContent();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        $this->assertStringStartsWith('attachment;filename=', $client->getResponse()->headers->get('content-disposition'));

        $this->assertNotNull($content, 'Response should not be null');
    }
}
