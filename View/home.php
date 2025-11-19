<?php $titulo = "Clínica Saúde - Página Inicial"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container hero-bg w3-padding-128">
    <div class="w3-content">
        <h1 class="w3-xxxlarge"><b>🏥 Clínica Saúde</b></h1>
        <p class="w3-xlarge">Sua saúde em primeiro lugar - Cuidando de você com excelência</p>
    </div>
</div>

<div class="w3-container w3-padding-64">
    <div class="w3-row-padding w3-center">
        <div class="w3-col l3 m6 w3-margin-bottom">
            <div class="w3-card-4 w3-padding-32 card-hover">
                <i class="fas fa-user-md w3-xxlarge w3-text-blue"></i>
                <h3>👨‍⚕️ Área do Médico</h3>
                <p>Acesse para gerenciar consultas e pacientes.</p>
                <a href="index.php?action=login" class="w3-button w3-blue">Acessar</a>
            </div>
        </div>
        
        <div class="w3-col l3 m6 w3-margin-bottom">
            <div class="w3-card-4 w3-padding-32 card-hover">
                <i class="fas fa-user-tie w3-xxlarge w3-text-orange"></i>
                <h3>👩‍💼 Área da Secretaria</h3>
                <p>Gerencie agendamentos e o fluxo da clínica.</p>
                <a href="index.php?action=login" class="w3-button w3-orange">Acessar</a>
            </div>
        </div>
        
        <div class="w3-col l3 m6 w3-margin-bottom">
            <div class="w3-card-4 w3-padding-32 card-hover">
                <i class="fas fa-user w3-xxlarge w3-text-green"></i>
                <h3>👤 Área do Paciente</h3>
                <p>Agende consultas e visualize seu histórico.</p>
                <a href="index.php?action=login" class="w3-button w3-green">Acessar</a>
            </div>
        </div>
        
        <div class="w3-col l3 m6 w3-margin-bottom">
            <div class="w3-card-4 w3-padding-32 card-hover">
                <i class="fas fa-cogs w3-xxlarge w3-text-red"></i>
                <h3>⚙️ Administração</h3>
                <p>Painel administrativo para gestão do sistema.</p>
                <a href="index.php?action=login" class="w3-button w3-red">Acessar</a>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>