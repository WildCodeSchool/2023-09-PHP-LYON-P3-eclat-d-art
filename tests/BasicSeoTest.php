<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicSeoTest extends WebTestCase
{
    public function testH1Presence(): void
    {
        static::createClient();
        $this->assertSelectorTextContains('h1', 'Artwork');
    }
}
