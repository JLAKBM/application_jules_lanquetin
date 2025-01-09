<?php

use PHPUnit\Framework\TestCase;

class ExempleRepositoryIntegrationTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Connexion à une base de données de test
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("
            CREATE TABLE users (
                id INTEGER PRIMARY KEY,
                name TEXT,
                email TEXT
            )
        ");
    }

    public function testUserCanBeSavedAndRetrieved()
    {
        $repository = new UserRepository($this->pdo);

        // Insérer un utilisateur
        $repository->save(['name' => 'John Doe', 'email' => 'john@example.com']);

        // Vérifier que l'utilisateur peut être récupéré
        $user = $repository->findByEmail('john@example.com');
        $this->assertEquals('John Doe', $user['name']);
    }
}
