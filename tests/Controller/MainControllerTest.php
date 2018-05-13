<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class MainControllerTest extends WebTestCase
{
    public function testLoadingPagesMain()
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadingPagesLogin()
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadingPagesRegistration()
    {
        $client = self::createClient();

        $client->request('GET', '/registration');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoadingPagesRoomList()
    {
        $client = self::createClient();

        $client->request(
            'GET',
            '/rooms/list',
            array(),
            array(),
            array(
                'CONTENT_TYPE'          => 'application/json',
                'HTTP_REFERER'          => '/foo/bar',
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}