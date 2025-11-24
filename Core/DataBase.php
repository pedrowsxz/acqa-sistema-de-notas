<?php 
// Singleton para conexão com MySQL
namespace Core;

use PDO;
use PDOException;
class Database {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $dbname = 'phpmyadmin';
    private $username = 'pedro';
    private $password = '';

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>