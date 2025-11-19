<?php

class Paciente
{
    private $conn;
    private $table_name = "pacientes";

    public $id;
    public $usuario_id;
    public $convenio;
    public $numero_convenio;
    public $contato_emergencia;
    public $telefone_emergencia;
    public $alergias;
    public $medicamentos_uso;
    public $historico_familiar;
    public $observacoes;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . "
                  SET usuario_id=:usuario_id, convenio=:convenio, 
                  numero_convenio=:numero_convenio, contato_emergencia=:contato_emergencia,
                  telefone_emergencia=:telefone_emergencia, alergias=:alergias,
                  medicamentos_uso=:medicamentos_uso, historico_familiar=:historico_familiar,
                  observacoes=:observacoes";

        $stmt = $this->conn->prepare($query);

        $this->convenio = htmlspecialchars(strip_tags($this->convenio));
        $this->numero_convenio = htmlspecialchars(strip_tags($this->numero_convenio));
        $this->contato_emergencia = htmlspecialchars(strip_tags($this->contato_emergencia));
        $this->telefone_emergencia = htmlspecialchars(strip_tags($this->telefone_emergencia));
        $this->alergias = htmlspecialchars(strip_tags($this->alergias));
        $this->medicamentos_uso = htmlspecialchars(strip_tags($this->medicamentos_uso));
        $this->historico_familiar = htmlspecialchars(strip_tags($this->historico_familiar));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));

     
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":convenio", $this->convenio);
        $stmt->bindParam(":numero_convenio", $this->numero_convenio);
        $stmt->bindParam(":contato_emergencia", $this->contato_emergencia);
        $stmt->bindParam(":telefone_emergencia", $this->telefone_emergencia);
        $stmt->bindParam(":alergias", $this->alergias);
        $stmt->bindParam(":medicamentos_uso", $this->medicamentos_uso);
        $stmt->bindParam(":historico_familiar", $this->historico_familiar);
        $stmt->bindParam(":observacoes", $this->observacoes);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }


    public function listar()
    {
        $query = "SELECT 
                    p.*, 
                    u.nome, u.email, u.cpf, u.telefone, 
                    u.data_nascimento, u.endereco
                  FROM " . $this->table_name . " p
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                  WHERE u.ativo = 1
                  ORDER BY u.nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

  
    public function buscarPorId($id)
    {
        $query = "SELECT 
                    p.*, 
                    u.nome, u.email, u.cpf, u.telefone, 
                    u.data_nascimento, u.endereco, u.tipo
                  FROM " . $this->table_name . " p
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                  WHERE p.id = :id AND u.ativo = 1
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->usuario_id = $row['usuario_id'];
            $this->convenio = $row['convenio'];
            $this->numero_convenio = $row['numero_convenio'];
            $this->contato_emergencia = $row['contato_emergencia'];
            $this->telefone_emergencia = $row['telefone_emergencia'];
            $this->alergias = $row['alergias'];
            $this->medicamentos_uso = $row['medicamentos_uso'];
            $this->historico_familiar = $row['historico_familiar'];
            $this->observacoes = $row['observacoes'];

            return $row;
        }
        return false;
    }


    public function buscarPorUsuarioId($usuario_id)
    {
        $query = "SELECT 
                    p.*, 
                    u.nome, u.email, u.cpf, u.telefone, 
                    u.data_nascimento, u.endereco
                  FROM " . $this->table_name . " p
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                                    WHERE p.usuario_id = :usuario_id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . "
                  SET convenio=:convenio, numero_convenio=:numero_convenio, 
                  contato_emergencia=:contato_emergencia, telefone_emergencia=:telefone_emergencia,
                  alergias=:alergias, medicamentos_uso=:medicamentos_uso,
                  historico_familiar=:historico_familiar, observacoes=:observacoes
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);


        $this->convenio = htmlspecialchars(strip_tags($this->convenio));
        $this->numero_convenio = htmlspecialchars(strip_tags($this->numero_convenio));
        $this->contato_emergencia = htmlspecialchars(strip_tags($this->contato_emergencia));
        $this->telefone_emergencia = htmlspecialchars(strip_tags($this->telefone_emergencia));
        $this->alergias = htmlspecialchars(strip_tags($this->alergias));
        $this->medicamentos_uso = htmlspecialchars(strip_tags($this->medicamentos_uso));
        $this->historico_familiar = htmlspecialchars(strip_tags($this->historico_familiar));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));


        $stmt->bindParam(":convenio", $this->convenio);
        $stmt->bindParam(":numero_convenio", $this->numero_convenio);
        $stmt->bindParam(":contato_emergencia", $this->contato_emergencia);
        $stmt->bindParam(":telefone_emergencia", $this->telefone_emergencia);
        $stmt->bindParam(":alergias", $this->alergias);
        $stmt->bindParam(":medicamentos_uso", $this->medicamentos_uso);
        $stmt->bindParam(":historico_familiar", $this->historico_familiar);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function contarTotal()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " p
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                  WHERE u.ativo = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }


    public function buscarPorConvenio($convenio)
    {
        $query = "SELECT 
                    p.*, 
                    u.nome, u.email, u.cpf, u.telefone
                  FROM " . $this->table_name . " p
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                  WHERE p.convenio = :convenio AND u.ativo = 1
                  ORDER BY u.nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":convenio", $convenio);
        $stmt->execute();

        return $stmt;
    }


    public function excluir($id)
    {
 
        if ($this->buscarPorId($id)) {

            $query = "UPDATE usuarios SET ativo = 0 WHERE id = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $this->usuario_id);

            return $stmt->execute();
        }
        return false;
    }

    public function buscarComFiltros($filtros = [])
    {
        $query = "SELECT 
                    p.*, 
                    u.nome, u.email, u.cpf, u.telefone, 
                    u.data_nascimento, u.endereco
                  FROM " . $this->table_name . " p
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                  WHERE u.ativo = 1";


        if (isset($filtros['convenio'])) {
            $query .= " AND p.convenio = :convenio";
        }
        if (isset($filtros['nome'])) {
            $query .= " AND u.nome LIKE :nome";
        }

        $query .= " ORDER BY u.nome ASC";

        $stmt = $this->conn->prepare($query);


        if (isset($filtros['convenio'])) {
            $stmt->bindParam(":convenio", $filtros['convenio']);
        }
        if (isset($filtros['nome'])) {
            $nome = "%" . $filtros['nome'] . "%";
            $stmt->bindParam(":nome", $nome);
        }

        $stmt->execute();
        return $stmt;
    }


    public function buscarUltimos($limite = 5)
    {
        $query = "SELECT 
                p.*, 
                u.nome, u.email, u.cpf, u.telefone, 
                u.data_nascimento, u.endereco
              FROM " . $this->table_name . " p
              INNER JOIN usuarios u ON p.usuario_id = u.id
              WHERE u.ativo = 1
              ORDER BY p.id DESC
              LIMIT :limite";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();

        $resultados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        return $resultados;
    }
}
