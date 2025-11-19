<?php $titulo = $dados['titulo'] ?? 'Prontuários - Clínica de Saúde'; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-file-medical"></i> Prontuários</b></h1>
    <p class="w3-large">Dr(a). <?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? ''); ?></p>

    <div class="w3-card-4 w3-margin-top">
        <div class="w3-container w3-padding">
            <?php if (!empty($dados['prontuarios']) && is_array($dados['prontuarios'])): ?>
                <ul class="w3-ul">
                    <?php foreach ($dados['prontuarios'] as $r): ?>
                        <li class="w3-padding-16">
                            <div class="w3-row">
                                <div class="w3-col s3 m2 l2">
                                    <strong><?php echo date('d/m/Y H:i', strtotime($r['data_consulta'])); ?></strong>
                                </div>
                                <div class="w3-col s9 m10 l10">
                                    <strong><?php echo htmlspecialchars($r['paciente_nome']); ?></strong>
                                    <div class="w3-text-grey">Diagnóstico: <?php echo htmlspecialchars($r['diagnostico'] ?? '-'); ?></div>
                                    <div>Prescrição: <?php echo htmlspecialchars($r['prescricao'] ?? '-'); ?></div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="w3-padding-16 w3-center">
                    <p class="w3-text-grey">Nenhum prontuário encontrado.</p>
                </div>
            <?php endif; ?>
        </div>
        <footer class="w3-container w3-light-grey">
            <a href="index.php?action=medico" class="w3-button w3-blue">Voltar ao Painel</a>
        </footer>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>