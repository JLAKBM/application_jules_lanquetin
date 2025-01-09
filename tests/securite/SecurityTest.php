<?php
use PHPUnit\Framework\TestCase;

class SecurityTest extends TestCase
{
    public function testSqlInjection()
    {
        $input = "' OR 1=1 --";
        $result = safeQuery($input); // Remplacez par votre fonction de requête sécurisée
        $this->assertNotContains('1=1', $result, 'Vulnérabilité SQL détectée');
    }

    public function testXssProtection()
    {
        $input = "<script>alert('XSS')</script>";
        $escapedInput = escapeInput($input); // Remplacez par votre méthode d'échappement
        $this->assertStringNotContainsString('<script>', $escapedInput, 'Vulnérabilité XSS détectée');
    }
}