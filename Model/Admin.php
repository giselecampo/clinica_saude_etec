<?php
require_once 'Usuario.php';

class Admin extends Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db = null) {
        $this->conn = $db ?: require '../db.php';
    }

    public function getAdminByUsuarioId($usuario_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = :usuario_id AND tipo = 'admin'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEstatisticasSistema() {
        $estatisticas = [];

 
        $query = "SELECT tipo, COUNT(*) as total FROM usuarios WHERE ativo = 1 GROUP BY tipo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $estatisticas['usuarios_por_tipo'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT status, COUNT(*) as total FROM consultas GROUP BY status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $estatisticas['consultas_por_status'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT COUNT(*) as total FROM pacientes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $estatisticas['total_pacientes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];


        $query = "SELECT COUNT(*) as total FROM consultas WHERE DATE(data_consulta) = CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $estatisticas['consultas_hoje'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        return $estatisticas;
    }
}
?>