<?php

namespace Controllers;

use DAO\UserDAO;
use Models\User;

class AuthController {
    public function showRegister() {
        include __DIR__ . '/../Views/auth/register.php';
    }

    public function register() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            echo "Email e senha são obrigatórios";
            return;
        }

        $dao = new UserDAO();
        $existing = $dao->findByEmail($email);
        if ($existing) {
            echo "Usuário já existe";
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $user = new User(null, $name, $email, $hash);
        $id = $dao->create($user);

        header('Location: /login');
    }

    public function showLogin() {
        include __DIR__ . '/../Views/auth/login.php';
    }

    public function login() {
        session_start();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $dao = new UserDAO();
        $row = $dao->findByEmail($email);
        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: /dashboard');
            return;
        }

        echo "Credenciais inválidas";
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
    }
}

?>
