<?php $titulo = $dados['titulo'] ?? 'Minha Agenda - Clínica de Saúde'; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-calendar-alt"></i> Minha Agenda</b></h1>
    <p class="w3-large">Dr(a). <?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? ''); ?></p>

    <div class="w3-card-4 w3-margin-top">
        <div class="w3-container w3-padding">
            <?php if (!empty($dados['agenda']) && is_array($dados['agenda'])): ?>
                <ul class="w3-ul">
                    <?php foreach ($dados['agenda'] as $consulta): ?>
                        <li class="w3-padding-16">
                            <div class="w3-row">
                                <div class="w3-col s4 m3 l2">
                                    <strong><?php echo date('d/m H:i', strtotime($consulta['data_consulta'])); ?></strong>
                                </div>
                                <div class="w3-col s8 m9 l10">
                                    <strong><?php echo htmlspecialchars($consulta['paciente_nome']); ?></strong>
                                    <div class="w3-text-grey">Status: <?php echo htmlspecialchars($consulta['status']); ?></div>
                                    <div><?php echo htmlspecialchars($consulta['tipo_consulta'] ?? ''); ?></div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="w3-padding-16 w3-center">
                    <p class="w3-text-grey">Nenhuma consulta agendada para os próximos dias.</p>
                </div>
            <?php endif; ?>
        </div>
        <footer class="w3-container w3-light-grey">
            <a href="index.php?action=medico" class="w3-button w3-blue">Voltar ao Painel</a>
        </footer>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>