<?php

define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
// Calcula Base URL dinamicamente (suporta servir em raiz ou em subpasta)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
// Host com porta (ex: localhost:8000) — usado para construir BASE_URL e preservar porta
$hostForUrl = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');

// Calcular o caminho base do script (por exemplo '/clinica_saude' ou '')
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$basePath = rtrim(dirname($scriptName), "\\/");
if ($basePath === '.' || $basePath === '') {
    $basePath = '';
}

define('BASE_URL', $scheme . '://' . $hostForUrl . $basePath . '/');

// Define parâmetros explícitos do cookie de sessão para evitar incompatibilidades de caminho/domínio e em seguida inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    // Determina o domínio do cookie (host sem porta) e calcula um caminho de cookie
    // compatível tanto para implantação em subpasta quanto para servir na raiz (built-in server).
    $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');
    if (strpos($host, ':') !== false) {
        $host = explode(':', $host)[0];
    }

    // Calcular o caminho base do script (por exemplo '/clinica_saude' ou '/').
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/';
    $basePath = rtrim(dirname($scriptName), "\\/");
    if ($basePath === '.' || $basePath === '') {
        $cookiePath = '/';
    } else {
        $cookiePath = $basePath . '/';
    }

    // Configurações recomendadas de sessão do PHP para comportamento previsível
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookiePath,
        'domain' => $host,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    // Garante um caminho de armazenamento de sessão gravável dentro do projeto para evitar problemas de permissão do SO
    $sessDir = ROOT_PATH . 'tmp/sessions';
    if (!is_dir($sessDir)) {
        @mkdir($sessDir, 0755, true);
    }
    // Define `session.save_path` para a pasta `tmp` do projeto
    if (is_dir($sessDir) && is_writable($sessDir)) {
        session_save_path($sessDir);
    }

    session_start();
}


spl_autoload_register(function ($classe) {
    $caminhos = [
        ROOT_PATH . 'Controller/' . $classe . '.php',
        ROOT_PATH . 'Model/' . $classe . '.php'
    ];

    foreach ($caminhos as $caminho) {
        if (file_exists($caminho)) {
            require_once $caminho;
            return;
        }
    }
});

require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'db.php'; 


function carregarClasse($classe)
{
    $caminhos = [
        ROOT_PATH . 'Controller/' . $classe . '.php',
        ROOT_PATH . 'Model/' . $classe . '.php'
    ];

    foreach ($caminhos as $caminho) {
        if (file_exists($caminho)) {
            require_once $caminho;
            return;
        }
    }
}

spl_autoload_register('carregarClasse');

function verificarAuth()
{
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?action=login");
        exit;
    }
}

function verificarPermissao($tiposPermitidos)
{
    if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], $tiposPermitidos)) {
        $_SESSION['erro'] = "Acesso não autorizado!";
        header("Location: index.php?action=dashboard");
        exit;
    }
}

$action = $_GET['action'] ?? 'home';
$id = $_GET['id'] ?? null;


try {
    switch ($action) {

        case 'home':
            require ROOT_PATH . 'View/home.php';
            break;

        case 'login':
            $controller = new AuthController();
            $controller->login();
            break;

        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;

        case 'registro':
            $controller = new AuthController();
            $controller->registro();
            break;

        case 'dashboard':
            verificarAuth();
            $controller = new DashboardController();
            $controller->index();
            break;

        case 'admin':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new AdminController();
            $controller->dashboard();
            break;

        case 'medico':
            verificarAuth();
            verificarPermissao(['medico']);
            $controller = new MedicoController();
            $controller->dashboard();
            break;

        case 'secretaria':
            verificarAuth();
            verificarPermissao(['secretaria']);
            $controller = new SecretariaController();
            $controller->dashboard();
            break;

        case 'paciente':
            verificarAuth();
            verificarPermissao(['paciente']);
            $controller = new PacienteController();
            $controller->dashboard();
            break;


        case 'usuarios':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new AdminController();
            $controller->usuarios();
            break;

        case 'pacientes':
            verificarAuth();
            verificarPermissao(['admin', 'medico', 'secretaria']);
            $controller = new PacienteController();
            $controller->listar();
            break;

        case 'paciente_cadastrar':
            verificarAuth();
            verificarPermissao(['admin', 'secretaria']);
            $controller = new PacienteController();
            $controller->cadastrar();
            break;

        case 'paciente_completar':
            // Página para o próprio paciente completar/registrar seu perfil
            verificarAuth();
            verificarPermissao(['paciente','admin','secretaria']);
            $controller = new PacienteController();
            $controller->cadastrar();
            break;

        case 'paciente_visualizar':
            verificarAuth();
            verificarPermissao(['admin', 'medico', 'secretaria']);
            $controller = new PacienteController();
            $controller->visualizar($id);
            break;

        case 'consultas':
            verificarAuth();
            $controller = new ConsultaController();
            $controller->listar();
            break;

        case 'consulta_agendar':
            verificarAuth();
            verificarPermissao(['admin', 'secretaria', 'paciente']);
            $controller = new ConsultaController();
            $controller->agendar();
            break;

        case 'exames':
            verificarAuth();
            // permitir que pacientes (e equipes) vejam a página informativa de exames
            verificarPermissao(['paciente','medico','secretaria','admin']);
            require ROOT_PATH . 'View/paciente/exames.php';
            break;

        case 'medicos':
            verificarAuth();
            // permitir que pacientes vejam a lista pública de médicos
            verificarPermissao(['paciente','medico','secretaria','admin']);
            $controller = new PublicController();
            $controller->medicos();
            break;

        case 'exame_solicitar':
            verificarAuth();
            // permitir médicos, secretarias, pacientes e admins ver a página informativa
            verificarPermissao(['medico','secretaria','paciente','admin']);
            require ROOT_PATH . 'View/medico/exame_solicitar.php';
            break;

        case 'financeiro':
            verificarAuth();
            // permitir apenas secretaria e admin acessarem o controle financeiro informativo
            verificarPermissao(['secretaria','admin']);
            require ROOT_PATH . 'View/secretaria/financeiro.php';
            break;

        case 'consulta_cancelar':
            verificarAuth();
            $controller = new ConsultaController();
            $controller->cancelar($id);
            break;

        case 'minhas_consultas':
            verificarAuth();
            verificarPermissao(['medico']);
            $controller = new MedicoController();
            $controller->minhasConsultas();
            break;

        case 'agenda':
            verificarAuth();
            verificarPermissao(['medico']);
            $controller = new MedicoController();
            $controller->agenda();
            break;

        case 'prontuarios':
            verificarAuth();
            verificarPermissao(['medico']);
            $controller = new MedicoController();
            $controller->prontuarios();
            break;

        case 'gerenciar_pacientes':
            verificarAuth();
            verificarPermissao(['secretaria']);
            $controller = new SecretariaController();
            $controller->gerenciarPacientes();
            break;

        case 'gerenciar_consultas':
            verificarAuth();
            verificarPermissao(['secretaria']);
            $controller = new SecretariaController();

            require ROOT_PATH . 'View/secretaria/consultas.php';
            break;

        case 'relatorios':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new RelatorioController();
            $controller->index();
            break;

        case 'relatorio_gerar':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new RelatorioController();
            $controller->gerarRelatorio($_GET['tipo'] ?? '');
            break;

        case 'usuario_criar':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new AdminController();
            $controller->criarUsuario();
            break;

        case 'usuario_excluir':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new AdminController();
            $controller->usuarioExcluir($id);
            break;


        case 'usuario_editar':
            verificarAuth();
            verificarPermissao(['admin']);
            $controller = new AdminController();
            $controller->editarUsuario($id);
            break;

        // caso duplicado 'usuario_criar' removido

        default:
            http_response_code(404);
            echo "<div class='w3-container w3-padding-64'>";
            echo "<div class='w3-card-4 w3-padding-32 w3-center'>";
            echo "<i class='fas fa-exclamation-triangle w3-xxlarge w3-text-orange'></i>";
            echo "<h1>Página não encontrada</h1>";
            echo "<p>A ação '<strong>$action</strong>' não existe.</p>";
            echo "<a href='index.php?action=home' class='w3-button w3-blue'>Voltar para Home</a>";
            echo "</div></div>";
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "<div class='w3-container w3-padding-64'>";
    echo "<div class='w3-card-4 w3-padding-32 w3-center'>";
    echo "<i class='fas fa-bug w3-xxlarge w3-text-red'></i>";
    echo "<h1>Erro no sistema</h1>";
    echo "<p>Ocorreu um erro inesperado. Tente novamente mais tarde.</p>";
    echo "<details class='w3-left-align w3-margin-top'>";
    echo "<summary>Detalhes técnicos (para desenvolvimento)</summary>";
    echo "<pre class='w3-padding w3-light-grey'>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "</details>";
    echo "<a href='index.php?action=home' class='w3-button w3-blue w3-margin-top'>Voltar para Home</a>";
    echo "</div></div>";
}
