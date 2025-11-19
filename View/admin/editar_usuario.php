<?php $titulo = "Editar Usuário - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width: 800px; margin: 0 auto;">
    <div class="w3-card-4 w3-white">
        <header class="w3-container w3-blue">
            <h2><i class="fas fa-edit"></i> Editar Usuário</h2>
        </header>

        <form method="POST" action="<?php echo BASE_URL; ?>index.php?action=usuario_editar&id=<?php echo $dados['usuario']->id; ?>" class="w3-container w3-padding-32">

            <!-- Dados Básicos -->
            <fieldset class="w3-padding-16">
                <legend class="w3-large w3-text-blue"><i class="fas fa-user"></i> Dados Básicos</legend>

                <div class="w3-row-padding">
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>Nome Completo *</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="nome" required
                            value="<?php echo htmlspecialchars($dados['usuario']->nome); ?>">
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>CPF *</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="cpf" required
                            value="<?php echo htmlspecialchars($dados['usuario']->cpf); ?>">
                    </div>
                </div>

                <div class="w3-row-padding w3-margin-top">
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>Email *</b></label>
                        <input class="w3-input w3-border w3-round" type="email" name="email" required
                            value="<?php echo htmlspecialchars($dados['usuario']->email); ?>">
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>Telefone</b></label>
                        <input class="w3-input w3-border w3-round" type="tel" name="telefone"
                            value="<?php echo htmlspecialchars($dados['usuario']->telefone); ?>">
                    </div>
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-blue"><b>Data de Nascimento</b></label>
                    <input class="w3-input w3-border w3-round" type="date" name="data_nascimento"
                        value="<?php echo $dados['usuario']->data_nascimento; ?>">
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-blue"><b>Endereço</b></label>
                    <textarea class="w3-input w3-border w3-round" name="endereco" rows="3"><?php echo htmlspecialchars($dados['usuario']->endereco); ?></textarea>
                </div>
            </fieldset>

            <!-- Tipo e Especialização -->
            <fieldset class="w3-padding-16">
                <legend class="w3-large w3-text-green"><i class="fas fa-user-tag"></i> Tipo e Permissões</legend>

                <div class="w3-row-padding">
                    <div class="w3-half">
                        <label class="w3-text-green"><b>Tipo de Usuário *</b></label>
                        <select class="w3-select w3-border w3-round" name="tipo" required>
                            <option value="admin" <?php echo $dados['usuario']->tipo == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="medico" <?php echo $dados['usuario']->tipo == 'medico' ? 'selected' : ''; ?>>Médico</option>
                            <option value="secretaria" <?php echo $dados['usuario']->tipo == 'secretaria' ? 'selected' : ''; ?>>Secretária</option>
                            <option value="paciente" <?php echo $dados['usuario']->tipo == 'paciente' ? 'selected' : ''; ?>>Paciente</option>
                        </select>
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-green"><b>Status</b></label>
                        <select class="w3-select w3-border w3-round" name="ativo">
                            <option value="1" <?php echo $dados['usuario']->ativo ? 'selected' : ''; ?>>Ativo</option>
                            <option value="0" <?php echo !$dados['usuario']->ativo ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>
                </div>

                <!-- Campos específicos para médicos -->
                <div id="camposMedico" style="display: <?php echo $dados['usuario']->tipo == 'medico' ? 'block' : 'none'; ?>;">
                    <div class="w3-row-padding w3-margin-top">
                        <div class="w3-half">
                            <label class="w3-text-green"><b>CRM</b></label>
                            <input class="w3-input w3-border w3-round" type="text" name="crm"
                                value="<?php echo htmlspecialchars($dados['usuario']->crm); ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-green"><b>Especialidade</b></label>
                            <input class="w3-input w3-border w3-round" type="text" name="especialidade"
                                value="<?php echo htmlspecialchars($dados['usuario']->especialidade); ?>">
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Botões -->
            <div class="w3-bar w3-margin-top">
                <button type="submit" class="w3-button w3-green w3-large">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
                <a href="<?php echo BASE_URL; ?>index.php?action=usuarios" class="w3-button w3-blue w3-large w3-right">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Mostrar/ocultar campos de médico conforme o tipo selecionado
    document.querySelector('select[name="tipo"]').addEventListener('change', function() {
        const camposMedico = document.getElementById('camposMedico');
        camposMedico.style.display = this.value === 'medico' ? 'block' : 'none';
    });
</script>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>