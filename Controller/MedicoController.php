<?php

class MedicoController {
    private $consultaModel;
    private $pacienteModel;
    private $prontuarioModel;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->consultaModel = new Consulta($db);
        $this->pacienteModel = new Paciente($db);
        // Carrega modelo de prontuarios (pode não existir em versões antigas)
        if (file_exists(ROOT_PATH . 'Model/Prontuario.php')) {
            $this->prontuarioModel = new Prontuario($db);
        }
    }


    public function dashboard() {
        $medico_id = $_SESSION['usuario_id'];

        $filtros = [
            'medico_id' => $medico_id,
            'data_inicio' => date('Y-m-d')
        ];
        $consultasHoje = $this->consultaModel->listar($filtros);
        
        $dados = [
            'consultasHoje' => $consultasHoje,
            'titulo' => 'Dashboard Médico'
        ];

        require_once ROOT_PATH . 'View/medico/dashboard.php';
    }


    public function minhasConsultas() {
        $medico_id = $_SESSION['usuario_id'];
        
        $filtros = ['medico_id' => $medico_id];
        $consultas = $this->consultaModel->listar($filtros);
        
        $dados = [
            'consultas' => $consultas,
            'titulo' => 'Minhas Consultas'
        ];

        require_once ROOT_PATH . 'View/medico/consultas.php';
    }

    /**
     * Exibe a agenda do médico (próximas consultas a partir de hoje).
     */
    public function agenda() {
        $medico_id = $_SESSION['usuario_id'];

        $filtros = [
            'medico_id' => $medico_id,
            'data_inicio' => date('Y-m-d')
        ];

        $agenda = $this->consultaModel->listar($filtros);

        $dados = [
            'agenda' => $agenda,
            'titulo' => 'Minha Agenda'
        ];

        require_once ROOT_PATH . 'View/medico/agenda.php';
    }

    /**
     * Exibe lista de prontuários do médico.
     */
    public function prontuarios() {
        if (!isset($this->prontuarioModel)) {
            // Se o model não existir, exibe mensagem amigável
            http_response_code(404);
            echo "<div class='w3-container w3-padding-64'><div class='w3-card-4 w3-padding-32 w3-center'><h1>Prontuários indisponíveis</h1><p>O recurso de prontuários não está implementado no servidor.</p><a href='index.php?action=medico' class='w3-button w3-blue'>Voltar</a></div></div>";
            return;
        }

        $medico_id = $_SESSION['usuario_id'];
        $prontuarios = $this->prontuarioModel->listarPorMedico($medico_id);

        $dados = [
            'prontuarios' => $prontuarios,
            'titulo' => 'Prontuários'
        ];

        require_once ROOT_PATH . 'View/medico/prontuarios.php';
    }
}
?>