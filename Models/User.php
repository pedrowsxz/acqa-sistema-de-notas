<?php

namespace Models;

class User {
    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($id = null, $name = '', $email = '', $password = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function toArray() {
        return ['id' => $this->id, 'name' => $this->name, 'email' => $this->email, 'password' => $this->password];
    }
}
