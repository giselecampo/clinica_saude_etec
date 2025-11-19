<?php
class Database {
    private $host = 'localhost:3306';
    private $db_name = 'clinica_saude';
    private $username = 'root';
    private $password = 'usbw';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            die("Erro de conexão: " . $exception->getMessage());
        }
        return $this->conn;
    }
}


try {
    $database = new Database();
    $conn = $database->getConnection();
} catch(Exception $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>