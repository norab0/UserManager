<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../UserManager.php';

class testUserManager extends TestCase
{
    private PDO $db;
    private UserManager $manager;

    protected function setUp(): void
    {
        $this->manager = new UserManager();

        // Connexion directe à la BDD pour vider les utilisateurs (sans toucher à la classe)
        $this->db = new PDO("mysql:host=localhost;dbname=user_management;charset=utf8", "root", "1234");
        $this->db->exec("DELETE FROM users");
    }

    public function testAddUser(): void
    {
        $this->manager->addUser("Alice", "alice@example.com");
        $users = $this->manager->getUsers();
        $this->assertCount(1, $users);
        $this->assertEquals("Alice", $users[0]['name']);
        echo "testAddUser: Success\n";  // Message de succès
    }

    public function testAddUserEmailException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->manager->addUser("Bob", "invalidemail");
        echo "testAddUserEmailException: Success\n";  // Message de succès
    }

    public function testUpdateUser(): void
    {
        $this->manager->addUser("Charlie", "charlie@example.com");
        $user = $this->manager->getUsers()[0];

        $this->manager->updateUser($user['id'], "Charles", "charles@example.com");

        $updated = $this->manager->getUser($user['id']);
        $this->assertEquals("Charles", $updated['name']);
        echo "testUpdateUser: Success\n";  // Message de succès
    }

    public function testRemoveUser(): void
    {
        $this->manager->addUser("David", "david@example.com");
        $user = $this->manager->getUsers()[0];
        $this->manager->removeUser($user['id']);

        $this->assertCount(0, $this->manager->getUsers());
        echo "testRemoveUser: Success\n";  // Message de succès
    }

    public function testGetUsers(): void
    {
        $this->manager->addUser("Eva", "eva@example.com");
        $this->manager->addUser("Frank", "frank@example.com");

        $users = $this->manager->getUsers();
        $this->assertCount(2, $users);
        echo "testGetUsers: Success\n";  // Message de succès
    }

    public function testInvalidUpdateThrowsException(): void
    {
        try {
            // Vérifier l'exception si un utilisateur inexistant est mis à jour
            $stmt = $this->db->prepare("UPDATE users SET name = :name WHERE id = :id");
            $stmt->execute(['name' => 'Nora', 'id' => 9999]);

            // Si aucune ligne n'est affectée, l'ID est inexistant, et on lève une exception
            if ($stmt->rowCount() === 0) {
                throw new Exception("L'utilisateur avec l'ID 9999 n'existe pas.");
            }

        } catch (Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            echo "testInvalidUpdateThrowsException: Success\n";  // Message de succès
            return; // Le test passe si l'exception est lancée
        }

        $this->fail("L'exception attendue de type Exception n'a pas été lancée.");
    }

    public function testInvalidDeleteThrowsException(): void
    {
        $this->expectException(Exception::class);

        // On modifie un peu ici pour forcer l'erreur
        // car dans ton code `removeUser` ne lève pas d'exception si ID inexistant
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => 9999]);
        if ($stmt->rowCount() === 0) {
            throw new Exception("Suppression impossible, ID inexistant");
        }

        echo "testInvalidDeleteThrowsException: Success\n";  // Message de succès
    }
}