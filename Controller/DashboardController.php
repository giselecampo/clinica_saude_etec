<?php

class DashboardController {
    private $usuarioModel;
    private $pacienteModel;
    private $consultaModel;
    
    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->usuarioModel = new Usuario($db);
        $this->pacienteModel = new Paciente($db);
        $this->consultaModel = new Consulta($db);
    }

    public function index() {
        if (!isset($_SESSION['usuario_tipo'])) {
            header("Location: index.php?action=login");
            exit;
        }

   
        switch ($_SESSION['usuario_tipo']) {
            case 'admin':
                header("Location: index.php?action=admin");
                exit;
            case 'medico':
                header("Location: index.php?action=medico");
                exit;
            case 'secretaria':
                header("Location: index.php?action=secretaria");
                exit;
            case 'paciente':
                header("Location: index.php?action=paciente");
                exit;
            default:
                header("Location: index.php?action=home");
                exit;
        }
    }
}
?>