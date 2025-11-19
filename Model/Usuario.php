<?php

class Usuario
{
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $cpf;
    public $telefone;
    public $data_nascimento;
    public $endereco;
    public $tipo;
    public $crm;
    public $especialidade;
    public $ativo;
    public $data_criacao;
    public $data_atualizacao;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function login($email, $senha)
    {
        $query = "SELECT id, nome, email, senha, tipo, ativo 
                  FROM " . $this->table_name . " 
                  WHERE email = :email AND ativo = 1 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $row['senha'])) {
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->email = $row['email'];
                $this->tipo = $row['tipo'];
                return true;
            }
        }
        return false;
    }


    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nome=:nome, email=:email, senha=:senha, 
                  cpf=:cpf, telefone=:telefone, data_nascimento=:data_nascimento,
                  endereco=:endereco, tipo=:tipo, crm=:crm, especialidade=:especialidade";

        $stmt = $this->conn->prepare($query);


        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));
        $this->crm = htmlspecialchars(strip_tags($this->crm));
        $this->especialidade = htmlspecialchars(strip_tags($this->especialidade));


        $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);


        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":data_nascimento", $this->data_nascimento);
        $stmt->bindParam(":endereco", $this->endereco);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":crm", $this->crm);
        $stmt->bindParam(":especialidade", $this->especialidade);

        try {
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Não relançar a exceção — permitir que o controller trate/exiba uma mensagem amigável
            return false;
        }
    }


    public function listar($tipo = null)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ativo = 1";

        if ($tipo) {
            $query .= " AND tipo = :tipo";
        }

        $query .= " ORDER BY nome ASC";

        $stmt = $this->conn->prepare($query);

        if ($tipo) {
            $stmt->bindParam(":tipo", $tipo);
        }

        $stmt->execute();
        return $stmt;
    }


    public function buscarPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->email = $row['email'];
            $this->cpf = $row['cpf'];
            $this->telefone = $row['telefone'];
            $this->data_nascimento = $row['data_nascimento'];
            $this->endereco = $row['endereco'];
            $this->tipo = $row['tipo'];
            $this->crm = $row['crm'];
            $this->especialidade = $row['especialidade'];
            $this->ativo = $row['ativo'];

            return true;
        }
        return false;
    }


    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . "
                  SET nome=:nome, email=:email, cpf=:cpf, 
                  telefone=:telefone, data_nascimento=:data_nascimento,
                  endereco=:endereco, tipo=:tipo, crm=:crm, 
                  especialidade=:especialidade, ativo=:ativo
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);


        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->cpf = htmlspecialchars(strip_tags($this->cpf));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));
        $this->crm = htmlspecialchars(strip_tags($this->crm));
        $this->especialidade = htmlspecialchars(strip_tags($this->especialidade));


        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":data_nascimento", $this->data_nascimento);
        $stmt->bindParam(":endereco", $this->endereco);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":crm", $this->crm);
        $stmt->bindParam(":especialidade", $this->especialidade);
        $stmt->bindParam(":ativo", $this->ativo);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function emailExiste($email)
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }


    public function buscarMedicos()
    {
        $query = "SELECT id, nome, crm, especialidade, telefone 
                  FROM " . $this->table_name . " 
                  WHERE tipo = 'medico' AND ativo = 1 
                  ORDER BY nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function excluir($id)
    {
        $query = "UPDATE " . $this->table_name . " SET ativo = 0 WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /**
     * Exclui permanentemente o usuário e dados relacionados (paciente, consultas, exames, prontuarios).
     * Executa em transação e retorna true em sucesso ou false em falha.
     */
    public function excluirDefinitivo($id)
    {
        try {
            $this->conn->beginTransaction();

            // Buscar IDs de pacientes vinculados a este usuário
            $query = "SELECT id FROM pacientes WHERE usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $id);
            $stmt->execute();
            $pacienteIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($pacienteIds)) {
                // Preparar lista para IN (...) de forma segura
                $placeholders = implode(',', array_fill(0, count($pacienteIds), '?'));

                // Deletar consultas vinculadas
                $q = "DELETE FROM consultas WHERE paciente_id IN ($placeholders)";
                $s = $this->conn->prepare($q);
                foreach ($pacienteIds as $k => $pid) {
                    $s->bindValue($k + 1, $pid, PDO::PARAM_INT);
                }
                $s->execute();

                // Deletar exames vinculados
                $q = "DELETE FROM exames WHERE paciente_id IN ($placeholders)";
                $s = $this->conn->prepare($q);
                foreach ($pacienteIds as $k => $pid) {
                    $s->bindValue($k + 1, $pid, PDO::PARAM_INT);
                }
                $s->execute();

                // Deletar prontuarios vinculados
                $q = "DELETE FROM prontuarios WHERE paciente_id IN ($placeholders)";
                $s = $this->conn->prepare($q);
                foreach ($pacienteIds as $k => $pid) {
                    $s->bindValue($k + 1, $pid, PDO::PARAM_INT);
                }
                $s->execute();
            }

            // Deletar registros da tabela pacientes
            $q = "DELETE FROM pacientes WHERE usuario_id = :usuario_id";
            $s = $this->conn->prepare($q);
            $s->bindParam(":usuario_id", $id);
            $s->execute();

            // Deletar usuário
            $q = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $s = $this->conn->prepare($q);
            $s->bindParam(":id", $id);
            $s->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            return false;
        }
    }


    public function contarPorTipo($tipo = null)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE ativo = 1";

        if ($tipo) {
            $query .= " AND tipo = :tipo";
        }

        $stmt = $this->conn->prepare($query);

        if ($tipo) {
            $stmt->bindParam(":tipo", $tipo);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }
}
