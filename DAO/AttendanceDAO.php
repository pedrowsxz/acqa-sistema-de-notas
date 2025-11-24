<?php

namespace DAO;

class AttendanceDAO {
    private $file;

    public function __construct() {
        $this->file = __DIR__ . '/../storage/attendances.json';
        if (!file_exists(dirname($this->file))) {
            mkdir(dirname($this->file), 0777, true);
        }
        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
    }

    private function readAll() {
        $data = json_decode(file_get_contents($this->file), true);
        return $data ?: [];
    }

    private function writeAll($items) {
        file_put_contents($this->file, json_encode(array_values($items), JSON_PRETTY_PRINT));
    }

    public function attend($userId, $eventId) {
        $items = $this->readAll();
        // prevent duplicate
        foreach ($items as $it) {
            if ($it['user_id'] == $userId && $it['event_id'] == $eventId) return false;
        }
        $items[] = ['user_id' => (int)$userId, 'event_id' => (int)$eventId, 'timestamp' => date('c')];
        $this->writeAll($items);
        return true;
    }

    public function listByEvent($eventId) {
        $items = $this->readAll();
        return array_values(array_filter($items, function($it) use ($eventId) { return $it['event_id'] == $eventId; }));
    }

    public function listByUser($userId) {
        $items = $this->readAll();
        return array_values(array_filter($items, function($it) use ($userId) { return $it['user_id'] == $userId; }));
    }
}
