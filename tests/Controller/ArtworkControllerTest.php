<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArtworkControllerTest extends WebTestCase
{
    public function testRoute(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/',
            [],
            [],
            ['HTTP_HOST' => 'localhost:8000/artwork']
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', "Oeuvres");
    }
}
