<?php

class AdminController
{
    private $usuarioModel;
    private $pacienteModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->usuarioModel = new Usuario($db);
        $this->pacienteModel = new Paciente($db);
    }


    public function dashboard()
    {
        $totalPacientes = $this->pacienteModel->contarTotal();
        $totalMedicos = $this->usuarioModel->contarPorTipo('medico');
        $totalSecretarias = $this->usuarioModel->contarPorTipo('secretaria');
        $pacientesStmt = $this->pacienteModel->listar();
        $ultimosPacientes = [];
        $count = 0;

        if ($pacientesStmt) {
            while ($row = $pacientesStmt->fetch(PDO::FETCH_ASSOC)) {
                if ($count < 5) {
                    $ultimosPacientes[] = $row;
                    $count++;
                } else {
                    break;
                }
            }
        }

        $dados = [
            'totalPacientes' => $totalPacientes,
            'totalMedicos' => $totalMedicos,
            'totalSecretarias' => $totalSecretarias,
            'ultimosPacientes' => $ultimosPacientes,
            'titulo' => 'Painel Administrativo'
        ];

        require_once ROOT_PATH . 'View/admin/dashboard.php';
    }

    public function usuarios()
    {
        $usuarios = $this->usuarioModel->listar();

        $dados = [
            'usuarios' => $usuarios,
            'titulo' => 'Gerenciar Usuários'
        ];

        require_once ROOT_PATH . 'View/admin/usuarios.php';
    }


    public function editarUsuario($id)
    {
        if (!$this->usuarioModel->buscarPorId($id)) {
            $_SESSION['erro'] = "Usuário não encontrado!";
            header("Location: " . BASE_URL . "index.php?action=usuarios");
            exit;
        }

        if ($_POST) {
            $this->usuarioModel->nome = $_POST['nome'] ?? '';
            $this->usuarioModel->email = $_POST['email'] ?? '';
            $this->usuarioModel->cpf = $_POST['cpf'] ?? '';
            $this->usuarioModel->telefone = $_POST['telefone'] ?? '';
            $this->usuarioModel->data_nascimento = $_POST['data_nascimento'] ?? '';
            $this->usuarioModel->endereco = $_POST['endereco'] ?? '';
            $this->usuarioModel->tipo = $_POST['tipo'] ?? '';
            $this->usuarioModel->crm = $_POST['crm'] ?? '';
            $this->usuarioModel->especialidade = $_POST['especialidade'] ?? '';
            $this->usuarioModel->ativo = $_POST['ativo'] ?? 1;

            if ($this->usuarioModel->atualizar()) {
                $_SESSION['sucesso'] = "Usuário atualizado com sucesso!";
                header("Location: " . BASE_URL . "index.php?action=usuarios");
                exit;
            } else {
                $_SESSION['erro'] = "Erro ao atualizar usuário!";
            }
        }

        $dados = [
            'usuario' => $this->usuarioModel,
            'titulo' => 'Editar Usuário'
        ];

        require_once ROOT_PATH . 'View/admin/editar_usuario.php';
    }

    public function criarUsuario()
    {
        if ($_POST) {
            $this->usuarioModel->nome = $_POST['nome'] ?? '';
            $this->usuarioModel->email = $_POST['email'] ?? '';
            $this->usuarioModel->senha = $_POST['senha'] ?? '';
            $this->usuarioModel->cpf = $_POST['cpf'] ?? '';
            $this->usuarioModel->telefone = $_POST['telefone'] ?? '';
            $this->usuarioModel->data_nascimento = $_POST['data_nascimento'] ?? '';
            $this->usuarioModel->endereco = $_POST['endereco'] ?? '';
            $this->usuarioModel->tipo = $_POST['tipo'] ?? '';
            $this->usuarioModel->crm = $_POST['crm'] ?? '';
            $this->usuarioModel->especialidade = $_POST['especialidade'] ?? '';

            if (
                empty($this->usuarioModel->nome) || empty($this->usuarioModel->email) ||
                empty($this->usuarioModel->senha)
            ) {
                $_SESSION['erro'] = "Nome, email e senha são obrigatórios!";
            } elseif ($this->usuarioModel->emailExiste($this->usuarioModel->email)) {
                $_SESSION['erro'] = "Este email já está cadastrado!";
            } else {
                try {
                    if ($this->usuarioModel->criar()) {
                        $_SESSION['sucesso'] = "Usuário criado com sucesso!";
                        header("Location: " . BASE_URL . "index.php?action=usuarios");
                        exit;
                    } else {
                        $_SESSION['erro'] = "Erro ao criar usuário! (verifique dados e duplicatas)";
                    }
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $_SESSION['erro'] = "Erro: email ou CPF já cadastrado (constraint de unicidade).";
                    } else {
                        $_SESSION['erro'] = "Erro ao criar usuário: " . $e->getMessage();
                    }
                }
            }
        }

        $dados = ['titulo' => 'Criar Usuário'];
        require_once ROOT_PATH . 'View/admin/criar_usuario.php';
    }

    public function usuarioExcluir($id)
    {
        if ($id == $_SESSION['usuario_id']) {
            $_SESSION['erro'] = "Você não pode excluir sua própria conta!";
        } else {
            if ($this->usuarioModel->excluirDefinitivo($id)) {
                $_SESSION['sucesso'] = "Usuário excluído permanentemente com sucesso!";
            } else {
                $_SESSION['erro'] = "Erro ao excluir usuário permanentemente!";
            }
        }

        header("Location: " . BASE_URL . "index.php?action=usuarios");
        exit;
    }


    public function usuarioCriar()
    {
        $this->criarUsuario();
    }
}
