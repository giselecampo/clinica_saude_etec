<?php $titulo = "Nossos Médicos - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width:1000px; margin: 30px auto;">
    <h2 class="w3-xxlarge"><i class="fas fa-user-md"></i> Nossos Médicos</h2>

    <?php if (empty($dados['medicos'])): ?>
        <div class="w3-panel w3-light-grey w3-padding-32">
            <p class="w3-large">No momento não há médicos cadastrados.</p>
            <a href="index.php?action=paciente" class="w3-button w3-teal">Voltar para Meu Painel</a>
        </div>
    <?php else: ?>
        <div class="w3-row-padding">
            <?php foreach ($dados['medicos'] as $medico): ?>
                <div class="w3-third w3-margin-bottom">
                    <div class="w3-card-4 w3-white w3-padding-16">
                        <h3>Dr. <?php echo htmlspecialchars($medico['nome']); ?></h3>
                        <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($medico['especialidade'] ?? 'Não informado'); ?></p>
                        <p><strong>CRM:</strong> <?php echo htmlspecialchars($medico['crm'] ?? '—'); ?></p>
                        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($medico['telefone'] ?? '—'); ?></p>
                        <div class="w3-margin-top">
                            <a href="index.php?action=consulta_agendar&medico_id=<?php echo urlencode($medico['id']); ?>" class="w3-button w3-blue w3-block">
                                Agendar com este médico
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="w3-margin-top">
        <a href="index.php?action=paciente" class="w3-button w3-teal">Voltar para Meu Painel</a>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>