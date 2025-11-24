<?php

namespace DAO;

use Models\User;
use Core\Database;
use PDO;
use PDOException;
class UserDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function listAll() {
        $stmt = $this->pdo->query('SELECT id, name, email FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(User $user) {
        $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $user->name,
            ':email' => $user->email,
            ':password' => $user->password
        ]);
        return $this->pdo->lastInsertId();
    }

    public function read($id) {
        $sql = 'SELECT id, name, email FROM users WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function update(User $user) {
        $sql = 'UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $user->name,
            ':email' => $user->email,
            ':password' => $user->password,
            ':id' => $user->id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    
    public function findByEmail($email) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
