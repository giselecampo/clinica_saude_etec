<?php $titulo = "Minhas Consultas - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-calendar-alt"></i> Minhas Consultas</b></h1>
    
    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=dashboard" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <?php if (in_array($_SESSION['usuario_tipo'], ['admin', 'secretaria', 'paciente'])): ?>
        <a href="index.php?action=consulta_agendar" class="w3-button w3-green w3-right">
            <i class="fas fa-calendar-plus"></i> Nova Consulta
        </a>
        <?php endif; ?>
    </div>

    <div class="w3-card-4">
        <header class="w3-container w3-teal">
            <h3><i class="fas fa-list"></i> Lista de Consultas</h3>
        </header>
        <div class="w3-container">
            <?php if (!empty($dados['consultas'])): ?>
                <table class="w3-table w3-striped w3-bordered w3-hoverable">
                    <thead>
                        <tr class="w3-light-grey">
                            <th>Data/Hora</th>
                            <th>
                                <?php echo $_SESSION['usuario_tipo'] == 'medico' ? 'Paciente' : 'Médico'; ?>
                            </th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados['consultas'] as $consulta): ?>
                        <tr>
                            <td>
                                <?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?>
                                <br><small><?php echo date('H:i', strtotime($consulta['data_consulta'])); ?></small>
                            </td>
                            <td>
                                <?php if ($_SESSION['usuario_tipo'] == 'medico'): ?>
                                    <?php echo htmlspecialchars($consulta['paciente_nome']); ?>
                                <?php else: ?>
                                    Dr. <?php echo htmlspecialchars($consulta['medico_nome']); ?>
                                    <?php if (isset($consulta['especialidade']) && $consulta['especialidade']): ?>
                                        <br><small><?php echo htmlspecialchars($consulta['especialidade']); ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($consulta['tipo_consulta']); ?></td>
                            <td>
                                <span class="w3-tag w3-<?php 
                                    echo $consulta['status'] == 'agendada' ? 'blue' : 
                                         ($consulta['status'] == 'realizada' ? 'green' : 'red'); 
                                ?>">
                                    <?php echo ucfirst($consulta['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($consulta['status'] == 'agendada'): ?>
                                    <a href="index.php?action=consulta_cancelar&id=<?php echo $consulta['id']; ?>" 
                                       class="w3-button w3-red w3-tiny"
                                       onclick="return confirm('Tem certeza que deseja cancelar esta consulta?')">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="w3-padding-32 w3-center">
                    <i class="fas fa-calendar-times w3-xxlarge w3-text-grey"></i>
                    <p class="w3-large w3-text-grey">Nenhuma consulta encontrada</p>
                    <?php if (in_array($_SESSION['usuario_tipo'], ['admin', 'secretaria', 'paciente'])): ?>
                    <a href="index.php?action=consulta_agendar" class="w3-button w3-green">
                        <i class="fas fa-calendar-plus"></i> Agendar Primeira Consulta
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>