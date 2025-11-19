<?php $titulo = "Minhas Consultas - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-stethoscope"></i> Minhas Consultas</b></h1>
    <p class="w3-large">Dr(a). <?php echo $_SESSION['usuario_nome']; ?></p>
    
    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=medico" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
        </a>
    </div>

    <div class="w3-card-4">
        <header class="w3-container w3-teal">
            <h3><i class="fas fa-list"></i> Consultas Agendadas</h3>
        </header>
        <div class="w3-container">
            <?php if (!empty($dados['consultas'])): ?>
                <table class="w3-table w3-striped w3-bordered w3-hoverable">
                    <thead>
                        <tr class="w3-light-grey">
                            <th>Data/Hora</th>
                            <th>Paciente</th>
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
                                <strong><?php echo htmlspecialchars($consulta['paciente_nome']); ?></strong>
                                <br><small>ID: <?php echo $consulta['paciente_id']; ?></small>
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
                                <a href="index.php?action=paciente_visualizar&id=<?php echo $consulta['paciente_id']; ?>" 
                                   class="w3-button w3-blue w3-tiny">
                                    <i class="fas fa-eye"></i> Ver Paciente
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="w3-padding-32 w3-center">
                    <i class="fas fa-calendar-times w3-xxlarge w3-text-grey"></i>
                    <p class="w3-large w3-text-grey">Nenhuma consulta agendada</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>