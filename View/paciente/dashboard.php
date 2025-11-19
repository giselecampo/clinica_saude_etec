<?php $titulo = "Meu Painel - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-user"></i> Meu Painel</b></h1>
    <p class="w3-large">Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?></p>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-third">
            <div class="w3-card-4 w3-blue w3-padding-32 w3-center">
                <i class="fas fa-calendar-check w3-jumbo"></i>
                <h2><?php echo count($dados['consultas'] ?? []); ?></h2>
                <p>Próximas Consultas</p>
            </div>
        </div>
        <div class="w3-third">
            <div class="w3-card-4 w3-green w3-padding-32 w3-center">
                <i class="fas fa-file-medical w3-jumbo"></i>
                <h2>5</h2>
                <p>Consultas Realizadas</p>
            </div>
        </div>
        <div class="w3-third">
            <div class="w3-card-4 w3-orange w3-padding-32 w3-center">
                <i class="fas fa-microscope w3-jumbo"></i>
                <h2>3</h2>
                <p>Exames Realizados</p>
            </div>
        </div>
    </div>
    <?php if (isset($dados['consultas']) && !empty($dados['consultas'])): ?>
        <ul class="w3-ul">
            <?php foreach ($dados['consultas'] as $consulta): ?>
                <li class="w3-padding-16">
                    <div class="w3-container">
                        <h4><b>Consulta #<?php echo $consulta['id']; ?></b></h4>
                        <p><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></p>
                        <p><i class="fas fa-clock"></i> <?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></p>
                        <span class="w3-tag w3-<?php echo $consulta['status'] == 'agendada' ? 'blue' : 'green'; ?>">
                            <?php echo ucfirst($consulta['status']); ?>
                        </span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="w3-padding-16 w3-center">
            <p class="w3-text-grey">Nenhuma consulta agendada.</p>
            <a href="index.php?action=consulta_agendar" class="w3-button w3-teal">
                <i class="fas fa-calendar-plus"></i> Agendar Primeira Consulta
            </a>
        </div>
    <?php endif; ?>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-teal">
                    <h3><i class="fas fa-calendar-alt"></i> Minhas Próximas Consultas</h3>
                </header>
                <div class="w3-container">
                    <?php if (!empty($dados['consultas'])): ?>
                        <ul class="w3-ul">
                            <?php foreach ($dados['consultas'] as $consulta): ?>
                                <li class="w3-padding-16">
                                    <div class="w3-container">
                                        <h4><b>Consulta #<?php echo $consulta['id']; ?></b></h4>
                                        <p><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></p>
                                        <p><i class="fas fa-clock"></i> <?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></p>
                                        <span class="w3-tag w3-<?php echo $consulta['status'] == 'agendada' ? 'blue' : 'green'; ?>">
                                            <?php echo ucfirst($consulta['status']); ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="w3-padding-16 w3-center">
                            <p class="w3-text-grey">Nenhuma consulta agendada.</p>
                            <a href="index.php?action=consulta_agendar" class="w3-button w3-teal">
                                <i class="fas fa-calendar-plus"></i> Agendar Primeira Consulta
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <footer class="w3-container w3-light-grey">
                    <a href="index.php?action=consultas" class="w3-button w3-teal w3-block">Ver Todas as Minhas Consultas</a>
                </footer>
            </div>
        </div>

        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-blue">
                    <h3><i class="fas fa-user-circle"></i> Meus Dados</h3>
                </header>
                <div class="w3-container">
                    <?php if ($dados['paciente']): ?>
                        <div class="w3-padding-16">
                            <p><strong>Nome:</strong> <?php echo htmlspecialchars($dados['paciente']['nome']); ?></p>
                            <p><strong>CPF:</strong> <?php echo htmlspecialchars($dados['paciente']['cpf']); ?></p>
                            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($dados['paciente']['telefone']); ?></p>
                            <p><strong>Convênio:</strong> <?php echo htmlspecialchars($dados['paciente']['convenio'] ?? 'Não informado'); ?></p>
                        </div>
                    <?php else: ?>
                        <div class="w3-padding-16 w3-center">
                            <p class="w3-text-grey">Complete seu cadastro para melhor atendimento.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="w3-card-4 w3-margin-top">
                <header class="w3-container w3-green">
                    <h3><i class="fas fa-bolt"></i> Ações Rápidas</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-padding-16">
                        <a href="index.php?action=consulta_agendar" class="w3-button w3-blue w3-block w3-left-align">
                            <i class="fas fa-calendar-plus"></i> Agendar Consulta
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=exames" class="w3-button w3-green w3-block w3-left-align">
                            <i class="fas fa-file-medical-alt"></i> Meus Exames
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=medicos" class="w3-button w3-purple w3-block w3-left-align">
                            <i class="fas fa-user-md"></i> Nossos Médicos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>