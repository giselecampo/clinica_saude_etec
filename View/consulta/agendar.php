<?php $titulo = "Agendar Consulta - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width: 800px; margin: 0 auto;">
    <div class="w3-card-4 w3-white">
        <header class="w3-container w3-blue">
            <h2><i class="fas fa-calendar-plus"></i> Agendar Nova Consulta</h2>
        </header>

        <form method="POST" action="index.php?action=consulta_agendar" class="w3-container w3-padding-32">
            
            <?php if ($_SESSION['usuario_tipo'] != 'paciente'): ?>
            <div class="w3-section">
                <label class="w3-text-blue"><b>Paciente *</b></label>
                <select class="w3-select w3-border w3-round" name="paciente_id" required>
                    <option value="">Selecione o paciente</option>
                    <?php foreach ($dados['pacientes'] as $paciente): ?>
                        <option value="<?php echo $paciente['id']; ?>">
                            <?php echo htmlspecialchars($paciente['nome']); ?> - <?php echo htmlspecialchars($paciente['cpf']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Médico *</b></label>
                <select class="w3-select w3-border w3-round" name="medico_id" required>
                    <option value="">Selecione o médico</option>
                    <?php foreach ($dados['medicos'] as $medico): ?>
                        <option value="<?php echo $medico['id']; ?>">
                            Dr. <?php echo htmlspecialchars($medico['nome']); ?> - <?php echo htmlspecialchars($medico['especialidade']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="w3-row-padding">
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>Data da Consulta *</b></label>
                        <input class="w3-input w3-border w3-round" type="date" name="data_consulta" required 
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>Hora da Consulta *</b></label>
                        <input class="w3-input w3-border w3-round" type="time" name="hora_consulta" required 
                               min="08:00" max="18:00">
                    </div>
                </div>
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Tipo de Consulta</b></label>
                <select class="w3-select w3-border w3-round" name="tipo_consulta">
                    <option value="Consulta de rotina">Consulta de rotina</option>
                    <option value="Retorno">Retorno</option>
                    <option value="Avaliação inicial">Avaliação inicial</option>
                    <option value="Emergência">Emergência</option>
                    <option value="Acompanhamento">Acompanhamento</option>
                </select>
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Observações</b></label>
                <textarea class="w3-input w3-border w3-round" name="observacoes" rows="4" 
                          placeholder="Observações sobre a consulta..."></textarea>
            </div>

            <div class="w3-bar w3-margin-top">
                <button type="submit" class="w3-button w3-green w3-large">
                    <i class="fas fa-calendar-check"></i> Agendar Consulta
                </button>
                <a href="index.php?action=consultas" class="w3-button w3-blue w3-large w3-right">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>