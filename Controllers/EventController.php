<?php

namespace Controllers;

use DAO\EventDAO;
use DAO\AttendanceDAO;
use Models\Event;

class EventController {
    public function index() {
        $dao = new EventDAO();
        echo json_encode($dao->listAll());
    }

    public function store() {
        $dados = $_POST;
        $event = new Event(null, $dados['title'] ?? '', $dados['description'] ?? '', $dados['date'] ?? '', $dados['creator_id'] ?? null);
        $dao = new EventDAO();
        $id = $dao->create($event);
        echo json_encode(['id' => $id]);
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $dao = new EventDAO();
            $event = $dao->read($id);
            $attendanceDao = new AttendanceDAO();
            $attendees = $attendanceDao->listByEvent($id);
            echo json_encode(['event' => $event, 'attendees' => $attendees]);
        } else {
            echo json_encode(['error' => 'ID not provided']);
        }
    }

    public function attend() {
        $userId = $_POST['user_id'] ?? null;
        $eventId = $_POST['event_id'] ?? null;
        if (!$userId || !$eventId) {
            echo json_encode(['error' => 'user_id and event_id required']);
            return;
        }
        $attendanceDao = new AttendanceDAO();
        $ok = $attendanceDao->attend($userId, $eventId);
        if ($ok) echo json_encode(['status' => 'attending']);
        else echo json_encode(['status' => 'already_attending']);
    }

    public function form() {
        include '../Views/events.php';
    }
}
