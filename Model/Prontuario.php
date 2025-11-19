<?php
class Prontuario {
    private $conn;
    private $table_name = 'prontuarios';

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Retorna os prontuários vinculados a um médico (com dados do paciente).
     */
    public function listarPorMedico($medico_id) {
        $query = "SELECT r.*, p.usuario_id as paciente_usuario_id, up.nome as paciente_nome
                  FROM " . $this->table_name . " r
                  INNER JOIN pacientes p ON r.paciente_id = p.id
                  INNER JOIN usuarios up ON p.usuario_id = up.id
                  WHERE r.medico_id = :medico_id
                  ORDER BY r.data_consulta DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':medico_id', $medico_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>