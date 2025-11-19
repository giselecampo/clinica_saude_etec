<?php $titulo = "Gerenciar Consultas - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-calendar-alt"></i> Gerenciar Consultas</b></h1>
    
    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=secretaria" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="index.php?action=consulta_agendar" class="w3-button w3-green w3-right">
            <i class="fas fa-calendar-plus"></i> Nova Consulta
        </a>
    </div>

    <div class="w3-card-4">
        <header class="w3-container w3-teal">
            <h3><i class="fas fa-list"></i> Todas as Consultas</h3>
        </header>
        <div class="w3-container">
            <div class="w3-padding-16">
                <p class="w3-large">Funcionalidade em desenvolvimento</p>
                <p>Em breve você poderá gerenciar todas as consultas do sistema aqui.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>