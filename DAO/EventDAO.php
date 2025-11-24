<?php

namespace DAO;

use Models\Event;

class EventDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function create(Event $e) {
        $sql = "INSERT INTO events (user_id,title,description,event_date) VALUES (:user_id,:title,:description,:event_date)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user_id'=>$e->user_id,
            ':title'=>$e->title,
            ':description'=>$e->description,
            ':event_date'=>$e->event_date
        ]);
    }

    public function update(Event $e) {
        $sql = "UPDATE events SET title=:title, description=:description, event_date=:event_date WHERE id=:id AND user_id=:user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
        ':title'=>$e->title,
        ':description'=>$e->description,
        ':event_date'=>$e->event_date,
        ':id'=>$e->id,
        ':user_id'=>$e->user_id
        ]);
    }

    public function delete($id, $user_id) {
        $sql = "DELETE FROM events WHERE id=:id AND user_id=:user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id'=>$id, ':user_id'=>$user_id]);
    }


    public function listAll() {
        $stmt = $this->pdo->query("SELECT * FROM events");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listByUser($user_id) {
        $sql = "SELECT * FROM events WHERE user_id = :user_id ORDER BY event_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id'=>$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function listById($id, $user_id) {
        $sql = "SELECT * FROM events WHERE id=:id AND user_id=:user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id'=>$id, ':user_id'=>$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}