<?php
require_once 'Usuario.php';

class Medico extends Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db = null) {
        $this->conn = $db ?: require '../db.php';
    }

    public function getAllMedicos() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE tipo = 'medico' AND ativo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMedicoById($id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :id AND tipo = 'medico'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMedicoByUsuarioId($usuario_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :usuario_id AND tipo = 'medico'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>