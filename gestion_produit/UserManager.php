<?php
class UserManager {
    private PDO $db;

    public function __construct() {
        $dsn = "mysql:host=localhost;dbname=user_management;charset=utf8";
        $username = "root"; // Modifier si besoin
        $password = "1234"; // Modifier si besoin
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function addUser(string $name, string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }

        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
    }

    
    
    public function removeUser(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getUsers(): array {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUser(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        if (!$user) throw new Exception("Utilisateur introuvable.");
        return $user;
    }

    public function updateUser(int $id, string $name, string $email): void {
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }
    // public function updateUser(int $id, string $name, string $email): void {
    //     // On prépare la mise à jour avec la gestion de la date d'ajout
    //     $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email, date_ajout = IFNULL(:date_ajout, NOW()) WHERE id = :id");
    //     $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email, 'date_ajout' => null]); // Si la valeur est NULL, NOW() sera utilisée
    // }
    // public function addUser(string $name, string $email): void {
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         throw new InvalidArgumentException("Email invalide.");
    //     }
    
    //     // Insertion de l'utilisateur avec la gestion de la date d'ajout (NOW() si NULL)
    //     $stmt = $this->db->prepare("INSERT INTO users (name, email, date_ajout) VALUES (:name, :email, IFNULL(:date_ajout, NOW()))");
    //     $stmt->execute(['name' => $name, 'email' => $email, 'date_ajout' => null]);  // La valeur null permettra de définir NOW() si c'est NULL
    // }
    
}
?>
