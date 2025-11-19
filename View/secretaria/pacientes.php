<?php $titulo = "Gerenciar Pacientes - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-user-injured"></i> Gerenciar Pacientes</b></h1>
    
    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=secretaria" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="index.php?action=paciente_cadastrar" class="w3-button w3-green w3-right">
            <i class="fas fa-user-plus"></i> Novo Paciente
        </a>
    </div>

    <div class="w3-card-4">
        <header class="w3-container w3-green">
            <h3><i class="fas fa-list"></i> Todos os Pacientes</h3>
        </header>
        <div class="w3-container">
            <?php if (!empty($dados['pacientes'])): ?>
                <table class="w3-table w3-striped w3-bordered w3-hoverable">
                    <thead>
                        <tr class="w3-light-grey">
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Convênio</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados['pacientes'] as $paciente): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($paciente['nome']); ?></strong>
                                <br><small class="w3-text-grey"><?php echo htmlspecialchars($paciente['email']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($paciente['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['telefone']); ?></td>
                            <td>
                                <?php if ($paciente['convenio']): ?>
                                    <span class="w3-tag w3-blue"><?php echo htmlspecialchars($paciente['convenio']); ?></span>
                                <?php else: ?>
                                    <span class="w3-text-grey">Não informado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo date('d/m/Y', strtotime($paciente['data_criacao'])); ?>
                            </td>
                            <td>
                                <a href="index.php?action=paciente_visualizar&id=<?php echo $paciente['id']; ?>" 
                                   class="w3-button w3-blue w3-tiny">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="index.php?action=consulta_agendar&paciente_id=<?php echo $paciente['id']; ?>" 
                                   class="w3-button w3-green w3-tiny">
                                    <i class="fas fa-calendar-plus"></i> Consulta
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="w3-padding-32 w3-center">
                    <i class="fas fa-user-injured w3-xxlarge w3-text-grey"></i>
                    <p class="w3-large w3-text-grey">Nenhum paciente cadastrado</p>
                    <a href="index.php?action=paciente_cadastrar" class="w3-button w3-green">
                        <i class="fas fa-user-plus"></i> Cadastrar Primeiro Paciente
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>