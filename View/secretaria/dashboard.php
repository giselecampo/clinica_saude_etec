<?php $titulo = "Dashboard Secretaria - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-desktop"></i> Painel da Secretaria</b></h1>
    <p class="w3-large">Bem-vinda, <?php echo $_SESSION['usuario_nome']; ?></p>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-quarter">
            <div class="w3-card-4 w3-blue w3-padding-32 w3-center">
                <i class="fas fa-calendar-alt w3-jumbo"></i>
                <h2><?php echo is_array($dados['consultasHoje'] ?? null) ? count($dados['consultasHoje']) : ($dados['consultasHoje'] ?? '0'); ?></h2>
                <p>Agendamentos Hoje</p>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-green w3-padding-32 w3-center">
                <i class="fas fa-user-plus w3-jumbo"></i>
                <h2><?php echo $dados['totalPacientes'] ?? '0'; ?></h2>
                <p>Total de Pacientes</p>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-orange w3-padding-32 w3-center">
                <i class="fas fa-phone w3-jumbo"></i>
                <h2>8</h2>
                <p>Ligações Pendentes</p>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-purple w3-padding-32 w3-center">
                <i class="fas fa-money-bill-wave w3-jumbo"></i>
                <h2>R$ 2.850</h2>
                <p>Receita do Dia</p>
            </div>
        </div>
    </div>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-teal">
                    <h3><i class="fas fa-list-alt"></i> Próximos Agendamentos</h3>
                </header>
                <?php if (isset($dados['proximasConsultas']) && !empty($dados['proximasConsultas'])): ?>
                    <table class="w3-table w3-striped w3-bordered">
                        <thead>
                            <tr class="w3-light-grey">
                                <th>Hora</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dados['proximasConsultas'] as $consulta): ?>
                                <tr>
                                    <td><?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></td>
                                    <td><?php echo htmlspecialchars($consulta['paciente_nome']); ?></td>
                                    <td>Dr. <?php echo htmlspecialchars($consulta['medico_nome']); ?></td>
                                    <td>
                                        <span class="w3-tag w3-<?php echo $consulta['status'] == 'agendada' ? 'blue' : 'green'; ?>">
                                            <?php echo ucfirst($consulta['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="w3-padding-16 w3-center">
                        <p class="w3-text-grey">Nenhum agendamento para hoje.</p>
                    </div>
                <?php endif; ?>
                <div class="w3-container">
                    <?php if (!empty($dados['proximasConsultas'])): ?>
                        <table class="w3-table w3-striped w3-bordered">
                            <thead>
                                <tr class="w3-light-grey">
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dados['proximasConsultas'] as $consulta): ?>
                                    <tr>
                                        <td><?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></td>
                                        <td><?php echo htmlspecialchars($consulta['paciente_nome']); ?></td>
                                        <td>Dr. <?php echo htmlspecialchars($consulta['medico_nome']); ?></td>
                                        <td>
                                            <span class="w3-tag w3-<?php echo $consulta['status'] == 'agendada' ? 'blue' : 'green'; ?>">
                                                <?php echo ucfirst($consulta['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="w3-padding-16 w3-center">
                            <p class="w3-text-grey">Nenhum agendamento para hoje.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <footer class="w3-container w3-light-grey">
                    <a href="index.php?action=consulta_agendar" class="w3-button w3-teal">
                        <i class="fas fa-plus"></i> Novo Agendamento
                    </a>
                    <a href="index.php?action=consultas" class="w3-button w3-blue w3-right">Ver Todos</a>
                </footer>
            </div>
        </div>

        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-blue">
                    <h3><i class="fas fa-tasks"></i> Tarefas Rápidas</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-padding-16">
                        <a href="index.php?action=paciente_cadastrar" class="w3-button w3-green w3-block w3-left-align">
                            <i class="fas fa-user-plus"></i> Cadastrar Novo Paciente
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=consulta_agendar" class="w3-button w3-blue w3-block w3-left-align">
                            <i class="fas fa-calendar-plus"></i> Agendar Consulta
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=financeiro" class="w3-button w3-purple w3-block w3-left-align">
                            <i class="fas fa-money-bill-wave"></i> Controle Financeiro
                        </a>
                    </div>
                    <div class="w3-padding-16">
                        <a href="index.php?action=pacientes" class="w3-button w3-orange w3-block w3-left-align">
                            <i class="fas fa-users"></i> Lista de Pacientes
                        </a>
                    </div>
                </div>
            </div>

            <div class="w3-card-4 w3-margin-top">
                <header class="w3-container w3-orange">
                    <h3><i class="fas fa-bell"></i> Lembretes</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-padding-16">
                        <p><i class="fas fa-phone w3-text-red"></i> <strong>Ligar para Ana - Confirmação consulta</strong></p>
                    </div>
                    <div class="w3-padding-16">
                        <p><i class="fas fa-file-invoice w3-text-blue"></i> <strong>Enviar faturas pendentes</strong></p>
                    </div>
                    <div class="w3-padding-16">
                        <p><i class="fas fa-calendar-check w3-text-green"></i> <strong>Confirmar agendamentos de amanhã</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>