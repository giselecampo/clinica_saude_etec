<?php
require_once 'Usuario.php';

class Secretaria extends Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db = null) {
        $this->conn = $db ?: require '../db.php';
    }

    public function getSecretariaByUsuarioId($usuario_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :usuario_id AND tipo = 'secretaria'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllSecretarias() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE tipo = 'secretaria' AND ativo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>