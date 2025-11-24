<?php

namespace Models;

class Event {
    public $id;
    public $title;
    public $description;
    public $date;
    public $creator_id;

    public function __construct($id = null, $title = '', $description = '', $date = '', $creator_id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->creator_id = $creator_id;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'creator_id' => $this->creator_id
        ];
    }
}
