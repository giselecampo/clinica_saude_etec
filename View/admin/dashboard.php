<?php $titulo = "Dashboard Administrativo - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-tachometer-alt"></i> Painel Administrativo</b></h1>
    <p class="w3-large">Visão geral do sistema</p>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-third">
            <div class="w3-card-4 w3-blue w3-padding-32 w3-center">
                <i class="fas fa-users w3-jumbo"></i>
                <h2><?php echo $dados['totalPacientes'] ?? '0'; ?></h2>
                <p>Total de Pacientes</p>
            </div>
        </div>
        <div class="w3-third">
            <div class="w3-card-4 w3-green w3-padding-32 w3-center">
                <i class="fas fa-user-md w3-jumbo"></i>
                <h2><?php echo $dados['totalMedicos'] ?? '0'; ?></h2>
                <p>Médicos Cadastrados</p>
            </div>
        </div>
        <div class="w3-third">
            <div class="w3-card-4 w3-teal w3-padding-32 w3-center">
                <i class="fas fa-user-tie w3-jumbo"></i>
                <h2><?php echo $dados['totalSecretarias'] ?? '0'; ?></h2>
                <p>Secretárias</p>
            </div>
        </div>
    </div>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-quarter">
            <div class="w3-card-4 w3-hover-shadow w3-padding-24 w3-center">
                <i class="fas fa-user-plus w3-xxlarge w3-text-blue"></i>
                <h4>Novo Usuário</h4>
                <a href="index.php?action=usuario_criar" class="w3-button w3-blue w3-block">Criar</a>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-hover-shadow w3-padding-24 w3-center">
                <i class="fas fa-users w3-xxlarge w3-text-green"></i>
                <h4>Gerenciar Usuários</h4>
                <a href="index.php?action=usuarios" class="w3-button w3-green w3-block">Acessar</a>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-hover-shadow w3-padding-24 w3-center">
                <i class="fas fa-user-injured w3-xxlarge w3-text-orange"></i>
                <h4>Pacientes</h4>
                <p>Gerencie todos os pacientes do sistema</p>
                <a href="index.php?action=pacientes" class="w3-button w3-orange w3-block">Ver Todos</a>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card-4 w3-hover-shadow w3-padding-24 w3-center">
                <i class="fas fa-chart-bar w3-xxlarge w3-text-purple"></i>
                <h4>Relatórios</h4>
                <p>Relatórios e estatísticas</p>
                <a href="index.php?action=relatorios" class="w3-button w3-purple w3-block">Gerar</a>
            </div>
        </div>
    </div>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-blue">
                    <h3><i class="fas fa-history"></i> Últimos Pacientes Cadastrados</h3>
                </header>
                <div class="w3-container">
                    <?php if (isset($dados['ultimosPacientes']) && is_array($dados['ultimosPacientes']) && !empty($dados['ultimosPacientes'])): ?>
                        <ul class="w3-ul">
                            <?php foreach ($dados['ultimosPacientes'] as $paciente): ?>
                                <?php if (is_array($paciente) && isset($paciente['nome'])): ?>
                                    <li class="w3-padding-16">
                                        <div class="w3-container">
                                            <h4><b><?php echo htmlspecialchars($paciente['nome']); ?></b></h4>
                                            <p>CPF: <?php echo htmlspecialchars($paciente['cpf'] ?? 'Não informado'); ?></p>
                                            <p>Telefone: <?php echo htmlspecialchars($paciente['telefone'] ?? 'Não informado'); ?></p>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="w3-padding-16 w3-center">
                            <p class="w3-text-grey">Nenhum paciente cadastrado ainda.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <footer class="w3-container w3-light-grey">
                    <a href="index.php?action=pacientes" class="w3-button w3-blue w3-block">Ver Todos os Pacientes</a>
                </footer>
            </div>
        </div>

        <div class="w3-half">
            <div class="w3-card-4">
                <header class="w3-container w3-green">
                    <h3><i class="fas fa-chart-pie"></i> Estatísticas do Sistema</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-padding-16">
                        <div class="w3-light-grey w3-round">
                            <div class="w3-container w3-blue w3-round" style="width:75%">Pacientes: 75%</div>
                        </div>
                    </div>
                    <div class="w3-padding-16">
                        <div class="w3-light-grey w3-round">
                            <div class="w3-container w3-green w3-round" style="width:60%">Médicos: 60%</div>
                        </div>
                    </div>
                    <div class="w3-padding-16">
                        <div class="w3-light-grey w3-round">
                            <div class="w3-container w3-orange w3-round" style="width:45%">Consultas/Mês: 45%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>