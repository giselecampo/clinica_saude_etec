<?php $titulo = "Perfil do Paciente - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=pacientes" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="index.php?action=consulta_agendar&paciente_id=<?php echo $dados['paciente']['id']; ?>"
            class="w3-button w3-green w3-right">
            <i class="fas fa-calendar-plus"></i> Agendar Consulta
        </a>
    </div>

    <div class="w3-row-padding">
        <div class="w3-third">
            <div class="w3-card-4">
                <header class="w3-container w3-blue">
                    <h3><i class="fas fa-user"></i> Dados Pessoais</h3>
                </header>
                <div class="w3-container w3-padding-16">
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($dados['paciente']['nome']); ?></p>
                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($dados['paciente']['cpf']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($dados['paciente']['email']); ?></p>
                    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($dados['paciente']['telefone']); ?></p>
                    <p><strong>Data Nasc.:</strong>
                        <?php
                        $dataNascimento = $dados['paciente']['data_nascimento'] ?? null;
                        if ($dataNascimento && $dataNascimento != '0000-00-00' && $dataNascimento != 'NULL') {
                            echo date('d/m/Y', strtotime($dataNascimento));
                        } else {
                            echo 'Não informada';
                        }
                        ?>
                    </p>

                    <p><strong>Endereço:</strong> <?php echo htmlspecialchars($dados['paciente']['endereco']); ?></p>
                </div>
            </div>
        </div>

        <div class="w3-third">
            <div class="w3-card-4">
                <header class="w3-container w3-green">
                    <h3><i class="fas fa-heartbeat"></i> Dados Médicos</h3>
                </header>
                <div class="w3-container w3-padding-16">
                    <p><strong>Convênio:</strong>
                        <?php echo $dados['paciente']['convenio'] ? htmlspecialchars($dados['paciente']['convenio']) : 'Não informado'; ?>
                    </p>
                    <p><strong>Nº Convênio:</strong>
                        <?php echo $dados['paciente']['numero_convenio'] ? htmlspecialchars($dados['paciente']['numero_convenio']) : 'Não informado'; ?>
                    </p>
                    <p><strong>Contato Emerg.:</strong>
                        <?php echo $dados['paciente']['contato_emergencia'] ? htmlspecialchars($dados['paciente']['contato_emergencia']) : 'Não informado'; ?>
                    </p>
                    <p><strong>Tel. Emerg.:</strong>
                        <?php echo $dados['paciente']['telefone_emergencia'] ? htmlspecialchars($dados['paciente']['telefone_emergencia']) : 'Não informado'; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="w3-third">
            <div class="w3-card-4">
                <header class="w3-container w3-teal">
                    <h3><i class="fas fa-bolt"></i> Ações Rápidas</h3>
                </header>
                <div class="w3-container w3-padding-16">
                    <div class="w3-padding-8">
                        <a href="index.php?action=consulta_agendar&paciente_id=<?php echo $dados['paciente']['id']; ?>"
                            class="w3-button w3-blue w3-block w3-left-align">
                            <i class="fas fa-calendar-plus"></i> Nova Consulta
                        </a>
                    </div>
                    <div class="w3-padding-8">
                        <a href="#" class="w3-button w3-green w3-block w3-left-align">
                            <i class="fas fa-microscope"></i> Solicitar Exame
                        </a>
                    </div>
                    <div class="w3-padding-8">
                        <a href="#" class="w3-button w3-orange w3-block w3-left-align">
                            <i class="fas fa-file-medical"></i> Ver Prontuário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>