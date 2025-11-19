<?php

class PacienteController
{
    private $pacienteModel;
    private $usuarioModel;
    private $consultaModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->pacienteModel = new Paciente($db);
        $this->usuarioModel = new Usuario($db);
        $this->consultaModel = new Consulta($db);
    }


    public function listar()
    {
        $pacientesStmt = $this->pacienteModel->listar();

  
        $pacientesArray = [];
        if ($pacientesStmt) {
            $pacientesArray = $pacientesStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $dados = [
            'pacientes' => $pacientesArray,  
            'titulo' => 'Lista de Pacientes'
        ];

        require_once ROOT_PATH . 'View/paciente/listar.php';
    }


    public function cadastrar()
    {
        if ($_POST) {
   
            $this->usuarioModel->nome = $_POST['nome'] ?? '';
            $this->usuarioModel->email = $_POST['email'] ?? '';
            $this->usuarioModel->senha = $_POST['senha'] ?? '123456'; 
            $this->usuarioModel->cpf = $_POST['cpf'] ?? '';
            $this->usuarioModel->telefone = $_POST['telefone'] ?? '';
            $this->usuarioModel->data_nascimento = $_POST['data_nascimento'] ?? '';
            $this->usuarioModel->endereco = $_POST['endereco'] ?? '';
            $this->usuarioModel->tipo = 'paciente';

            if ($this->usuarioModel->criar()) {
                
                $this->pacienteModel->usuario_id = $this->usuarioModel->id;
                $this->pacienteModel->convenio = $_POST['convenio'] ?? '';
                $this->pacienteModel->numero_convenio = $_POST['numero_convenio'] ?? '';
                $this->pacienteModel->contato_emergencia = $_POST['contato_emergencia'] ?? '';
                $this->pacienteModel->telefone_emergencia = $_POST['telefone_emergencia'] ?? '';
                $this->pacienteModel->alergias = $_POST['alergias'] ?? '';
                $this->pacienteModel->medicamentos_uso = $_POST['medicamentos_uso'] ?? '';
                $this->pacienteModel->historico_familiar = $_POST['historico_familiar'] ?? '';
                $this->pacienteModel->observacoes = $_POST['observacoes'] ?? '';

                if ($this->pacienteModel->criar()) {
                    $_SESSION['sucesso'] = "Paciente cadastrado com sucesso!";
                    header("Location: " . BASE_URL . "index.php?action=pacientes");
                    exit;
                } else {
                    $_SESSION['erro'] = "Erro ao criar perfil do paciente!";
                }
            } else {
                $_SESSION['erro'] = "Erro ao criar usuário!";
            }
        }

        $dados = ['titulo' => 'Cadastrar Paciente'];
        require_once ROOT_PATH . 'View/paciente/cadastrar.php';
    }


    public function visualizar($id)
    {
        $paciente = $this->pacienteModel->buscarPorId($id);

        if (!$paciente) {
            $_SESSION['erro'] = "Paciente não encontrado!";
            header("Location: " . BASE_URL . "index.php?action=pacientes");
            exit;
        }

        $dados = [
            'paciente' => $paciente,
            'titulo' => 'Perfil do Paciente'
        ];

        require_once ROOT_PATH . 'View/paciente/visualizar.php';
    }

    public function dashboard()
    {
        $pacienteInfo = $this->pacienteModel->buscarPorUsuarioId($_SESSION['usuario_id']);

        if (!$pacienteInfo) {
            // Não redirecionar automaticamente: mostrar o painel do paciente mesmo que o perfil esteja incompleto.
            // A view já trata a ausência de dados mostrando um convite para completar o cadastro.
            // Não setar uma mensagem de erro em sessão para evitar avisos indesejados.
            $pacienteInfo = false;
        }

        // Buscar apenas as consultas deste paciente (se houver perfil)
        if ($pacienteInfo && isset($pacienteInfo['id'])) {
            $consultas = $this->consultaModel->listar(['paciente_id' => $pacienteInfo['id']]);
        } else {
            $consultas = [];
        }

        $dados = [
            'paciente' => $pacienteInfo,
            'consultas' => $consultas,
            'titulo' => 'Meu Painel'
        ];

        require_once ROOT_PATH . 'View/paciente/dashboard.php';
    }
}
