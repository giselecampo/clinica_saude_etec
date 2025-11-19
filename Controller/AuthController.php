<?php
class AuthController {
    private $usuarioModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->usuarioModel = new Usuario($db);
    }

    /**
     * Exibe a página de login e processa tentativa de autenticação.
     */
    public function login() {
        // Se já estiver logado, redireciona conforme tipo
        if (isset($_SESSION['usuario_id'])) {
            $this->redirecionarPorTipo($_SESSION['usuario_tipo']);
            return;
        }

        if ($_POST) {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if (empty($email) || empty($senha)) {
                $_SESSION['erro'] = "Email e senha são obrigatórios!";
            } else {
                if ($this->usuarioModel->login($email, $senha)) {
                    // Regenera o id da sessão para prevenir ataques de session fixation
                    session_regenerate_id(true);

                    // Armazena dados do usuário na sessão
                    $_SESSION['usuario_id'] = $this->usuarioModel->id;
                    $_SESSION['usuario_nome'] = $this->usuarioModel->nome;
                    $_SESSION['usuario_email'] = $this->usuarioModel->email;
                    $_SESSION['usuario_tipo'] = $this->usuarioModel->tipo;

                    $_SESSION['sucesso'] = "Login realizado com sucesso!";

                    // Não fechar a sessão manualmente: deixa o PHP gravar ao fim do request.
                    // Redireciona para a área apropriada.
                    $this->redirecionarPorTipo($this->usuarioModel->tipo);
                    return;
                } else {
                    $_SESSION['erro'] = "Email ou senha incorretos!";
                }
            }
        }

        require_once ROOT_PATH . 'View/auth/login.php';
    }

    /**
     * Logout: remove dados da sessão e destrói.
     */
    public function logout() {
        $_SESSION = array();
        if (session_id() !== '') {
            session_destroy();
        }
        header("Location: index.php?action=home");
        exit;
    }

    /**
     * Registro de novos pacientes.
     */
    public function registro() {
        if (isset($_SESSION['usuario_id'])) {
            $this->redirecionarPorTipo($_SESSION['usuario_tipo']);
            return;
        }

        if ($_POST) {
            $this->usuarioModel->nome = $_POST['nome'] ?? '';
            $this->usuarioModel->email = $_POST['email'] ?? '';
            $this->usuarioModel->senha = $_POST['senha'] ?? '';
            $this->usuarioModel->cpf = $_POST['cpf'] ?? '';
            $this->usuarioModel->telefone = $_POST['telefone'] ?? '';
            $this->usuarioModel->data_nascimento = $_POST['data_nascimento'] ?? '';
            $this->usuarioModel->endereco = $_POST['endereco'] ?? '';
            $this->usuarioModel->tipo = 'paciente';

            if (empty($this->usuarioModel->nome) || empty($this->usuarioModel->email) || 
                empty($this->usuarioModel->senha) || empty($this->usuarioModel->cpf)) {
                $_SESSION['erro'] = "Todos os campos obrigatórios devem ser preenchidos!";
            } elseif ($this->usuarioModel->emailExiste($this->usuarioModel->email)) {
                $_SESSION['erro'] = "Este email já está cadastrado!";
            } elseif (strlen($this->usuarioModel->senha) < 6) {
                $_SESSION['erro'] = "A senha deve ter pelo menos 6 caracteres!";
            } else {
                try {
                    if ($this->usuarioModel->criar()) {
                        $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Faça login para continuar.";
                        header("Location: index.php?action=login");
                        exit;
                    } else {
                        $_SESSION['erro'] = "Erro ao realizar cadastro. Tente novamente (verifique duplicatas)";
                    }
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $_SESSION['erro'] = "Erro: email ou CPF já cadastrado (constraint de unicidade).";
                    } else {
                        $_SESSION['erro'] = "Erro ao realizar cadastro: " . $e->getMessage();
                    }
                }
            }
        }

        require_once ROOT_PATH . 'View/auth/registro.php';
    }

    private function redirecionarPorTipo($tipo) {
        switch ($tipo) {
            case 'admin': header("Location: index.php?action=admin"); break;
            case 'medico': header("Location: index.php?action=medico"); break;
            case 'secretaria': header("Location: index.php?action=secretaria"); break;
            case 'paciente': header("Location: index.php?action=paciente"); break;
            default: header("Location: index.php?action=dashboard"); break;
        }
        exit;
    }
}
?>