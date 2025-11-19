<?php

class RelatorioController
{
    private $pacienteModel;
    private $consultaModel;
    private $usuarioModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->pacienteModel = new Paciente($db);
        $this->consultaModel = new Consulta($db);
        $this->usuarioModel = new Usuario($db);
    }


    public function index()
    {
 
        $estatisticas = $this->carregarEstatisticas();

        $dados = [
            'estatisticas' => $estatisticas,
            'titulo' => 'Relatórios do Sistema'
        ];

        require_once ROOT_PATH . 'View/admin/relatorios.php';
    }


    public function gerarRelatorio($tipo)
    {
        header('Content-Type: application/json');

        $relatorio = [
            'tipo' => $tipo,
            'data_geracao' => date('d/m/Y H:i:s'),
            'total_registros' => 0,
            'estatisticas' => [],
            'receita_mensal' => 'R$ 0,00',
            'despesas_mensais' => 'R$ 0,00',
            'lucro_liquido' => 'R$ 0,00',
            'consultas_este_mes' => 0
        ];

   
        switch ($tipo) {
            case 'pacientes':
                $relatorio['total_registros'] = $this->pacienteModel->contarTotal();
                $relatorio['estatisticas'] = [
                    'total_pacientes' => $relatorio['total_registros'],
                    'novos_este_mes' => 5,
                    'pacientes_por_convenio' => [
                        ['convenio' => 'Unimed', 'total' => 10],
                        ['convenio' => 'Amil', 'total' => 8],
                        ['convenio' => 'Particular', 'total' => 5]
                    ]
                ];
                break;

            case 'consultas':
                $relatorio['total_registros'] = $this->consultaModel->contarPorStatus();
                $relatorio['estatisticas'] = [
                    'agendadas' => 15,
                    'realizadas' => 12,
                    'canceladas' => 3
                ];
                break;

            case 'financeiro':
                $relatorio['total_registros'] = 45;
                $relatorio['receita_mensal'] = 'R$ 8.500,00';
                $relatorio['despesas_mensais'] = 'R$ 3.200,00';
                $relatorio['lucro_liquido'] = 'R$ 5.300,00';
                $relatorio['consultas_este_mes'] = 45;
                break;
        }

        echo json_encode($relatorio);
        exit;
    }

 
    private function carregarEstatisticas()
    {
        return [
            'usuarios_por_tipo' => [
                ['tipo' => 'admin', 'total' => 1],
                ['tipo' => 'medico', 'total' => 3],
                ['tipo' => 'secretaria', 'total' => 2],
                ['tipo' => 'paciente', 'total' => 25]
            ],
            'pacientes' => [
                'total_pacientes' => $this->pacienteModel->contarTotal()
            ],
            'consultas_por_mes' => [
                ['mes' => 'Janeiro', 'total' => 42],
                ['mes' => 'Fevereiro', 'total' => 38],
                ['mes' => 'Março', 'total' => 45]
            ]
        ];
    }
}
