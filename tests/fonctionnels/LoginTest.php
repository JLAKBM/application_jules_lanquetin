<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LoginTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => 'http://localhost']);
    }

    public function testLoginWithValidCredentials()
    {
        $response = $this->client->post('/login', [
            'form_params' => [
                'email' => 'user@example.com',
                'password' => 'password123',
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Welcome', (string)$response->getBody());
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->client->post('/login', [
            'form_params' => [
                'email' => 'user@example.com',
                'password' => 'wrongpassword',
            ]
        ]);

        $this->assertEquals(401, $response->getStatusCode());
    }
}
