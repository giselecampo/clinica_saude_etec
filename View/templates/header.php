<?php
$usuarioLogado = isset($_SESSION['usuario_id']);
$usuarioNome = $_SESSION['usuario_nome'] ?? '';
$usuarioTipo = $_SESSION['usuario_tipo'] ?? '';
$isAdmin = $usuarioLogado && $usuarioTipo === 'admin';
$isMedico = $usuarioLogado && $usuarioTipo === 'medico';
$isSecretaria = $usuarioLogado && $usuarioTipo === 'secretaria';
$isPaciente = $usuarioLogado && $usuarioTipo === 'paciente';

// Nenhum log de depuração em produção — blocos de depuração removidos
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'Clínica de Saúde'; ?></title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-bg { background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%); color: white; }
        .card-hover:hover { transform: translateY(-5px); transition: transform 0.3s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .navbar-custom { background: linear-gradient(90deg, #1e88e5, #0d47a1); }
    </style>
</head>
<body class="w3-light-grey">

<header>
    <div class="w3-bar navbar-custom w3-text-white">
        <a href="index.php?action=home" class="w3-bar-item w3-button w3-hover-none">
            <i class="fas fa-heartbeat"></i> <strong>Clínica de Saúde</strong>
        </a>

        <?php if ($usuarioLogado): ?>
            <?php if ($isAdmin): ?>
                <a href="index.php?action=admin" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-tachometer-alt"></i> Admin
                </a>
                <a href="index.php?action=usuarios" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-users"></i> Usuários
                </a>
            <?php endif; ?>

            <?php if ($isMedico): ?>
                <a href="index.php?action=medico" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-stethoscope"></i> Dashboard
                </a>
                <a href="index.php?action=pacientes" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-user-injured"></i> Pacientes
                </a>
            <?php endif; ?>

            <?php if ($isSecretaria): ?>
                <a href="index.php?action=secretaria" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-desktop"></i> Dashboard
                </a>
                <a href="index.php?action=pacientes" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-user-injured"></i> Pacientes
                </a>
            <?php endif; ?>

            <?php if ($isPaciente): ?>
                <a href="index.php?action=paciente" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-user"></i> Meu Painel
                </a>
                <a href="index.php?action=consultas" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-calendar"></i> Minhas Consultas
                </a>
            <?php endif; ?>

            <div class="w3-right">
                <span class="w3-bar-item w3-tag <?php echo $isAdmin ? 'w3-red' : ($isMedico ? 'w3-teal' : ($isSecretaria ? 'w3-orange' : 'w3-blue')); ?>">
                    <?php echo $isAdmin ? '👑 Admin' : ($isMedico ? '👨‍⚕️ Médico' : ($isSecretaria ? '🧑‍💼 Secretária' : '👤 Paciente')); ?>
                </span>
                <span class="w3-bar-item">Olá, <strong><?php echo htmlspecialchars($usuarioNome); ?></strong></span>
                <a href="index.php?action=logout" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>

        <?php else: ?>
            <div class="w3-right">
                <a href="index.php?action=login" class="w3-bar-item w3-button w3-hover-white">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="index.php?action=registro" class="w3-bar-item w3-button w3-white w3-text-blue">
                    <i class="fas fa-user-plus"></i> Cadastrar
                </a>
            </div>
        <?php endif; ?>
    </div>
</header>

<?php if (isset($_SESSION['sucesso'])): ?>
    <div class="w3-panel w3-green w3-display-container">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-green w3-large w3-display-topright">&times;</span>
        <p><i class="fas fa-check-circle"></i> <?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></p>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="w3-panel w3-red w3-display-container">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-red w3-large w3-display-topright">&times;</span>
        <p><i class="fas fa-exclamation-triangle"></i> <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
    </div>
<?php endif; ?>

<main class="w3-container" style="min-height: 80vh;">