<?php

class Consulta {
    private $conn;
    private $table_name = "consultas";

    public $id;
    public $paciente_id;
    public $medico_id;
    public $data_consulta;
    public $status;
    public $tipo_consulta;
    public $observacoes;
    public $diagnostico;
    public $prescricao;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function agendar() {
        // Ajustado para usar apenas colunas existentes na tabela `consultas`.
        $query = "INSERT INTO " . $this->table_name . "
                  (paciente_id, medico_id, data_consulta, tipo_consulta, observacoes, status)
                  VALUES (:paciente_id, :medico_id, :data_consulta, :tipo_consulta, :observacoes, :status)";

        $stmt = $this->conn->prepare($query);

        $this->tipo_consulta = htmlspecialchars(strip_tags($this->tipo_consulta));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));

        $stmt->bindParam(":paciente_id", $this->paciente_id);
        $stmt->bindParam(":medico_id", $this->medico_id);
        $stmt->bindParam(":data_consulta", $this->data_consulta);
        $stmt->bindParam(":tipo_consulta", $this->tipo_consulta);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function listar($filtros = []) {
        $query = "SELECT 
                    c.*,
                    p.usuario_id as paciente_usuario_id,
                    up.nome as paciente_nome,
                    up.cpf as paciente_cpf,
                    um.nome as medico_nome,
                    um.especialidade as medico_especialidade
                  FROM " . $this->table_name . " c
                  INNER JOIN pacientes p ON c.paciente_id = p.id
                  INNER JOIN usuarios up ON p.usuario_id = up.id
                  INNER JOIN usuarios um ON c.medico_id = um.id
                  WHERE 1=1";

        if (isset($filtros['paciente_id'])) {
            $query .= " AND c.paciente_id = :paciente_id";
        }
        if (isset($filtros['medico_id'])) {
            $query .= " AND c.medico_id = :medico_id";
        }
        if (isset($filtros['status'])) {
            $query .= " AND c.status = :status";
        }
        if (isset($filtros['data_inicio'])) {
            $query .= " AND DATE(c.data_consulta) >= :data_inicio";
        }
        if (isset($filtros['data_fim'])) {
            $query .= " AND DATE(c.data_consulta) <= :data_fim";
        }

        $query .= " ORDER BY c.data_consulta DESC";

        $stmt = $this->conn->prepare($query);


        if (isset($filtros['paciente_id'])) {
            $stmt->bindParam(":paciente_id", $filtros['paciente_id']);
        }
        if (isset($filtros['medico_id'])) {
            $stmt->bindParam(":medico_id", $filtros['medico_id']);
        }
        if (isset($filtros['status'])) {
            $stmt->bindParam(":status", $filtros['status']);
        }
        if (isset($filtros['data_inicio'])) {
            $stmt->bindParam(":data_inicio", $filtros['data_inicio']);
        }
        if (isset($filtros['data_fim'])) {
            $stmt->bindParam(":data_fim", $filtros['data_fim']);
        }

        $stmt->execute();
        // Retornar um array com os resultados para uso direto nas views
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $query = "SELECT 
                    c.*,
                    p.usuario_id as paciente_usuario_id,
                    up.nome as paciente_nome,
                    up.cpf as paciente_cpf,
                    up.telefone as paciente_telefone,
                    um.nome as medico_nome,
                    um.especialidade as medico_especialidade,
                    um.crm as medico_crm
                  FROM " . $this->table_name . " c
                  INNER JOIN pacientes p ON c.paciente_id = p.id
                  INNER JOIN usuarios up ON p.usuario_id = up.id
                  INNER JOIN usuarios um ON c.medico_id = um.id
                  WHERE c.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            

            $this->id = $row['id'];
            $this->paciente_id = $row['paciente_id'];
            $this->medico_id = $row['medico_id'];
            $this->data_consulta = $row['data_consulta'];
            $this->status = $row['status'];
            $this->tipo_consulta = $row['tipo_consulta'];
            $this->observacoes = $row['observacoes'];
            $this->diagnostico = $row['diagnostico'] ?? null;
            $this->prescricao = $row['prescricao'] ?? null;
            
            return $row;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . "
              SET paciente_id=:paciente_id, medico_id=:medico_id, 
              data_consulta=:data_consulta, status=:status, 
              tipo_consulta=:tipo_consulta, observacoes=:observacoes,
              diagnostico=:diagnostico, prescricao=:prescricao
              WHERE id = :id";

        $stmt = $this->conn->prepare($query);


        $this->tipo_consulta = htmlspecialchars(strip_tags($this->tipo_consulta));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->diagnostico = htmlspecialchars(strip_tags($this->diagnostico));
        $this->prescricao = htmlspecialchars(strip_tags($this->prescricao));

        $stmt->bindParam(":paciente_id", $this->paciente_id);
        $stmt->bindParam(":medico_id", $this->medico_id);
        $stmt->bindParam(":data_consulta", $this->data_consulta);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":tipo_consulta", $this->tipo_consulta);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":diagnostico", $this->diagnostico);
        $stmt->bindParam(":prescricao", $this->prescricao);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

 
    public function verificarDisponibilidade($medico_id, $data_consulta) {
        $query = "SELECT id FROM " . $this->table_name . "
                  WHERE medico_id = :medico_id 
                  AND data_consulta = :data_consulta
                  AND status IN ('agendada', 'confirmada', 'em_andamento')
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":medico_id", $medico_id);
        $stmt->bindParam(":data_consulta", $data_consulta);
        $stmt->execute();

        return $stmt->rowCount() == 0;
    }


    public function contarPorStatus($status = null) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        
        if ($status) {
            $query .= " WHERE status = :status";
        }

        $stmt = $this->conn->prepare($query);
        
        if ($status) {
            $stmt->bindParam(":status", $status);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }
}
?>