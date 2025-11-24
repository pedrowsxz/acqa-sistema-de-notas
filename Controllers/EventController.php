<?php

namespace App\Controllers;

use App\DAO\EventDAO;
use App\Models\Event;

class EventController {
    private function requireAuth() {
        session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        return $_SESSION['user_id'];
    }

    public function dashboard() {
        $userId = $this->requireAuth();
        include __DIR__ . '/../Views/dashboard.php';
    }

    public function list() {
        $userId = $this->requireAuth();
        $dao = new EventDAO();
        header('Content-Type: application/json');
        echo json_encode($dao->listByUser($userId));
    }

    public function store() {
        $userId = $this->requireAuth();
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? null;

        $e = new Event(null, $userId, $title, $description, $date);
        $dao = new EventDAO();
        $id = $dao->create($e);
        echo json_encode(['id' => $id]);
    }

    public function show() {
        $userId = $this->requireAuth();
        $id = $_GET['id'] ?? null;
        if (!$id) { echo json_encode(['error' => 'id required']); return; }
        $dao = new EventDAO();
        echo json_encode($dao->find($id, $userId));
    }

    public function update() {
        $userId = $this->requireAuth();
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? null;

        $e = new Event($id, $userId, $title, $description, $date);
        $dao = new EventDAO();
        $dao->update($e);
        echo json_encode(['status' => 'updated']);
    }

    public function destroy() {
        $userId = $this->requireAuth();
        $id = $_POST['id'] ?? null;
        $dao = new EventDAO();
        $dao->delete($id, $userId);
        echo json_encode(['status' => 'deleted']);
    }
}

?>
