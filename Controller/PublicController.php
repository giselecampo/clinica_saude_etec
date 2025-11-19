<?php

class PublicController
{
    private $usuarioModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->usuarioModel = new Usuario($db);
    }

    public function medicos()
    {
        $stmt = $this->usuarioModel->buscarMedicos();

        // garantir array para view
        if ($stmt && is_object($stmt) && method_exists($stmt, 'fetchAll')) {
            $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (is_array($stmt)) {
            $medicos = $stmt;
        } else {
            $medicos = [];
        }

        $dados = [
            'medicos' => $medicos,
            'titulo' => 'Nossos Médicos'
        ];

        require_once ROOT_PATH . 'View/paciente/medicos.php';
    }
}
