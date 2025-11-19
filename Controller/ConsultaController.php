<?php

class ConsultaController {
    private $consultaModel;
    private $pacienteModel;
    private $usuarioModel;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->consultaModel = new Consulta($db);
        $this->pacienteModel = new Paciente($db);
        $this->usuarioModel = new Usuario($db);
    }


    public function listar() {
        $filtros = [];
        

        if ($_SESSION['usuario_tipo'] == 'medico') {
            $filtros['medico_id'] = $_SESSION['usuario_id'];
        } elseif ($_SESSION['usuario_tipo'] == 'paciente') {
            $pacienteInfo = $this->pacienteModel->buscarPorUsuarioId($_SESSION['usuario_id']);
            if ($pacienteInfo) {
                $filtros['paciente_id'] = $pacienteInfo['id'];
            }
        }
        
        $consultas = $this->consultaModel->listar($filtros);
        
        $dados = [
            'consultas' => $consultas,
            'titulo' => 'Minhas Consultas'
        ];

        require_once ROOT_PATH . 'View/consulta/listar.php';
    }


    public function agendar() {
        $medicos = $this->usuarioModel->buscarMedicos();
        $pacientes = $this->pacienteModel->listar();

        // Garantir que controllers passem arrays para as views (fetchAll quando for PDOStatement)
        if ($medicos && is_object($medicos) && method_exists($medicos, 'fetchAll')) {
            $medicos = $medicos->fetchAll(PDO::FETCH_ASSOC);
        }
        if ($pacientes && is_object($pacientes) && method_exists($pacientes, 'fetchAll')) {
            $pacientes = $pacientes->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($_POST) {
            // Se o usuário logado for paciente, usar o id do paciente vinculado ao usuário
            if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'paciente') {
                $pacienteInfo = $this->pacienteModel->buscarPorUsuarioId($_SESSION['usuario_id']);
                if ($pacienteInfo && isset($pacienteInfo['id'])) {
                    $this->consultaModel->paciente_id = $pacienteInfo['id'];
                } else {
                    // Tentar criar automaticamente um registro de paciente mínimo vinculado ao usuário
                    $this->pacienteModel->usuario_id = $_SESSION['usuario_id'];
                    // Campos opcionais podem ficar vazios — permitir criação mínima para agendamento
                    if ($this->pacienteModel->criar()) {
                        $this->consultaModel->paciente_id = $this->pacienteModel->id;
                        $_SESSION['sucesso'] = "Perfil de paciente criado automaticamente.";
                    } else {
                        $_SESSION['erro'] = "Perfil de paciente ausente. Não foi possível criar perfil automaticamente.";
                        header("Location: " . BASE_URL . "index.php?action=paciente");
                        exit;
                    }
                }
            } else {
                $this->consultaModel->paciente_id = $_POST['paciente_id'] ?? '';
            }
            $this->consultaModel->medico_id = $_POST['medico_id'] ?? '';

            $data = $_POST['data_consulta'] ?? '';
            $hora = $_POST['hora_consulta'] ?? '';
            if (!empty($hora)) {
                $this->consultaModel->data_consulta = trim($data . ' ' . $hora);
            } else {
                $this->consultaModel->data_consulta = $data;
            }

            $this->consultaModel->tipo_consulta = $_POST['tipo_consulta'] ?? 'Rotina';
            // O modelo atual salva observações; se o campo 'queixa_principal' for enviado,
            // usá-lo como observações caso o campo 'observacoes' esteja vazio.
            $queixa = $_POST['queixa_principal'] ?? '';
            $observ = $_POST['observacoes'] ?? '';
            $this->consultaModel->observacoes = !empty($observ) ? $observ : $queixa;
            $this->consultaModel->status = 'agendada';

            if ($this->consultaModel->agendar()) {
                $_SESSION['sucesso'] = "Consulta agendada com sucesso!";
                header("Location: " . BASE_URL . "index.php?action=consultas");
                exit;
            } else {
                $_SESSION['erro'] = "Erro ao agendar consulta!";
            }
        }

        $dados = [
            'medicos' => $medicos,
            'pacientes' => $pacientes,
            'titulo' => 'Agendar Consulta'
        ];

        require_once ROOT_PATH . 'View/consulta/agendar.php';
    }


    public function cancelar($id) {
        if ($this->consultaModel->buscarPorId($id)) {
            $this->consultaModel->status = 'cancelada';
            if ($this->consultaModel->atualizar()) {
                $_SESSION['sucesso'] = "Consulta cancelada com sucesso!";
            } else {
                $_SESSION['erro'] = "Erro ao cancelar consulta!";
            }
        } else {
            $_SESSION['erro'] = "Consulta não encontrada!";
        }
        
        header("Location: " . BASE_URL . "index.php?action=consultas");
        exit;
    }
}
?>