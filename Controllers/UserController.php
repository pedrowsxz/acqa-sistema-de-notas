<?php

namespace Controllers;

use DAO\UserDAO;
use Models\User;
use DAO\EventDAO;

class UserController {
    public function index() {
        $dao = new UserDAO();
        echo json_encode($dao->listAll());
    }

    // registration (store)
    public function store() {
        $dados = $_POST;
        $name = $dados['name'] ?? '';
        $email = $dados['email'] ?? '';
        $password = $dados['password'] ?? '';

        if (!$email || !$password) {
            echo json_encode(['error' => 'email and password required']);
            return;
        }

        $dao = new UserDAO();
        // check existing
        if ($dao->findByEmail($email)) {
            echo json_encode(['error' => 'email already registered']);
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $user = new User(null, $name, $email, $hash);
        $id = $dao->create($user);
        echo json_encode(['id' => $id]);
    }

    public function registerForm() {
        include __DIR__ . '/../Views/register.php';
    }

    public function loginForm() {
        include __DIR__ . '/../Views/login.php';
    }

    public function login() {
        session_start();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if (!$email || !$password) {
            header('Location: /form_login?error=missing');
            return;
        }
        $dao = new UserDAO();
        $row = $dao->findByEmail($email);
        if (!$row) {
            header('Location: /form_login?error=notfound');
            return;
        }
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = ['id' => $row['id'], 'name' => $row['name'], 'email' => $row['email']];
            header('Location: /dashboard');
        } else {
            header('Location: /form_login?error=invalid');
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /form_login');
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $dao = new UserDAO();
            echo json_encode($dao->read($id));
        } else {
            echo json_encode(['error' => 'ID not provided']);
        }
    }

    public function form() {
        include '../Views/users.php';
    }

    public function dashboard() {
        session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /form_login');
            return;
        }
        $user = $_SESSION['user'];
        $eventDao = new EventDAO();
        $events = $eventDao->listAll();
        // filter events created by this user
        $myEvents = array_filter($events, function($e) use ($user) {
            return isset($e['creator_id']) && $e['creator_id'] == $user['id'];
        });
        include __DIR__ . '/../Views/dashboard.php';
    }
}
