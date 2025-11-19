<?php $titulo = "Dashboard Médico - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-user-md"></i> Painel do Médico</b></h1>
    <p class="w3-large">Bem-vindo, Dr(a). <?php echo $_SESSION['usuario_nome']; ?></p>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-quarter">
            <div class="w3-card-4 w3-blue w3-padding-32 w3-center">
                <i class="fas fa-calendar-check w3-jumbo"></i>
                <h2><?php echo count($dados['consultasHoje'] ?? []); ?></h2>
                <p>Consultas Hoje</p>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-green w3-padding-32 w3-center">
                <i class="fas fa-user-clock w3-jumbo"></i>
                <h2>3</h2>
                <p>Em Espera</p>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-orange w3-padding-32 w3-center">
                <i class="fas fa-file-medical w3-jumbo"></i>
                <h2>5</h2>
                <p>Prontuários Pendentes</p>
            </div>
        </div>
        <?php if (isset($dados['consultasHoje']) && !empty($dados['consultasHoje'])): ?>
            <ul class="w3-ul">
                <?php foreach ($dados['consultasHoje'] as $consulta): ?>
                    <li class="w3-padding-16">
                        <div class="w3-container">
                            <h4><b><?php echo htmlspecialchars($consulta['paciente_nome']); ?></b></h4>
                            <p><i class="fas fa-clock"></i> <?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></p>
                            <p><span class="w3-tag w3-<?php echo $consulta['status'] == 'agendada' ? 'blue' : ($consulta['status'] == 'em_andamento' ? 'orange' : 'green'); ?>">
                                    <?php echo ucfirst($consulta['status']); ?>
                                </span></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="w3-padding-16 w3-center">
                <p class="w3-text-grey">Nenhuma consulta agendada para hoje.</p>
            </div>
        <?php endif; ?>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-purple w3-padding-32 w3-center">
                <i class="fas fa-microscope w3-jumbo"></i>
                <h2>2</h2>
                <p>Exames Solicitados</p>
            </div>
        </div>
    </div>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-teal">
                    <h3><i class="fas fa-calendar-day"></i> Consultas de Hoje</h3>
                </header>
                <div class="w3-container">
                    <?php if (!empty($dados['consultasHoje'])): ?>
                        <ul class="w3-ul">
                            <?php foreach ($dados['consultasHoje'] as $consulta): ?>
                                <li class="w3-padding-16">
                                    <div class="w3-container">
                                        <h4><b><?php echo htmlspecialchars($consulta['paciente_nome']); ?></b></h4>
                                        <p><i class="fas fa-clock"></i> <?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></p>
                                        <p><span class="w3-tag w3-<?php echo $consulta['status'] == 'agendada' ? 'blue' : ($consulta['status'] == 'em_andamento' ? 'orange' : 'green'); ?>">
                                                <?php echo ucfirst($consulta['status']); ?>
                                            </span></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="w3-padding-16 w3-center">
                            <p class="w3-text-grey">Nenhuma consulta agendada para hoje.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <footer class="w3-container w3-light-grey">
                    <a href="index.php?action=consultas" class="w3-button w3-teal w3-block">Ver Todas as Consultas</a>
                </footer>
            </div>
        </div>

        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-blue">
                    <h3><i class="fas fa-bolt"></i> Ações Rápidas</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-padding-16">
                        <a href="index.php?action=pacientes" class="w3-button w3-blue w3-block w3-left-align">
                            <i class="fas fa-user-injured"></i> Ver Meus Pacientes
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=prontuarios" class="w3-button w3-green w3-block w3-left-align">
                            <i class="fas fa-file-medical"></i> Prontuários
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=exame_solicitar" class="w3-button w3-orange w3-block w3-left-align">
                            <i class="fas fa-microscope"></i> Solicitar Exame
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=agenda" class="w3-button w3-purple w3-block w3-left-align">
                            <i class="fas fa-calendar-alt"></i> Minha Agenda
                        </a>
                    </div>
                </div>
            </div>

            <div class="w3-card-4 w3-margin-top">
                <header class="w3-container w3-orange">
                    <h3><i class="fas fa-calendar-week"></i> Próximos Compromissos</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-padding-16">
                        <p><strong>Amanhã - 09:00</strong><br>João Silva - Retorno</p>
                    </div>
                    <div class="w3-padding-16">
                        <p><strong>Amanhã - 14:30</strong><br>Maria Santos - Consulta Nova</p>
                    </div>
                    <div class="w3-padding-16">
                        <p><strong>Quinta - 10:15</strong><br>Pedro Costa - Acompanhamento</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>