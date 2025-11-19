<?php

class SecretariaController {
    private $pacienteModel;
    private $consultaModel;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->pacienteModel = new Paciente($db);
        $this->consultaModel = new Consulta($db);
    }


    public function dashboard() {
 
        $filtros = [
            'data_inicio' => date('Y-m-d'),
            'status' => 'agendada'
        ];
        $consultasHoje = $this->consultaModel->listar($filtros);

        // Fallback: se a query anterior retornar vazia por qualquer inconsistência,
        // buscamos todas as consultas com status 'agendada' e filtramos em PHP
        // para datas maiores ou iguais a hoje. Isso evita que o cartão mostre 0
        // quando há consultas agendadas.
        if (empty($consultasHoje)) {
            $allAgendadas = $this->consultaModel->listar(['status' => 'agendada']);
            $today = date('Y-m-d');
            $consultasHoje = array_filter($allAgendadas, function($c) use ($today) {
                return isset($c['data_consulta']) && date('Y-m-d', strtotime($c['data_consulta'])) >= $today;
            });
            // reindex array
            $consultasHoje = array_values($consultasHoje);
        }
        
        // Também fornecemos 'proximasConsultas' para a view que a espera
        $totalPacientes = 0;
        try {
            $pacientes = $this->pacienteModel->listar();
            $totalPacientes = is_array($pacientes) ? count($pacientes) : 0;
        } catch (Exception $e) {
            $totalPacientes = 0;
        }

        $dados = [
            'consultasHoje' => $consultasHoje,
            'proximasConsultas' => $consultasHoje,
            'totalPacientes' => $totalPacientes,
            'titulo' => 'Dashboard Secretaria'
        ];

        require_once ROOT_PATH . 'View/secretaria/dashboard.php';
    }


    public function gerenciarPacientes() {
        $pacientes = $this->pacienteModel->listar();
        
        $dados = [
            'pacientes' => $pacientes,
            'titulo' => 'Gerenciar Pacientes'
        ];

        require_once ROOT_PATH . 'View/secretaria/pacientes.php';
    }
}
?>