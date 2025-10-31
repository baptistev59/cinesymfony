<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CinemaControllerTest extends WebTestCase
{
    // Tester si la page de Programmation est disponible
    public function testProgrammationPageIsSuccessful(): void
    {
        $this->createClient()->request('GET', '/programmation');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Programmation');
    }
}