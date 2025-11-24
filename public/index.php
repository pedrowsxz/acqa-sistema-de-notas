<?php

require_once __DIR__ . '/../Core/Router.php';
require_once __DIR__ . '/../Core/Database.php';

// controllers
require_once __DIR__ . '/../Controllers/ClienteController.php';
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/EventController.php';

// DAOs and models
require_once __DIR__ . '/../DAO/ClienteDAO.php';
require_once __DIR__ . '/../DAO/UserDAO.php';
require_once __DIR__ . '/../DAO/EventDAO.php';
require_once __DIR__ . '/../Models/Cliente.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Event.php';

use Core\Router;
use Controllers\ClienteController;
use Controllers\AuthController;
use Controllers\EventController;

$router = new Router();

// Auth routes
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Event routes
$router->get('/dashboard', [EventController::class, 'dashboard']);
$router->get('/events', [EventController::class, 'list']);
$router->post('/event', [EventController::class, 'store']);
$router->get('/event', [EventController::class, 'show']);
$router->post('/event/update', [EventController::class, 'update']);
$router->post('/event/delete', [EventController::class, 'destroy']);

$router->run();
