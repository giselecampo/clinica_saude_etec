<?php $titulo = "Criar Usuário - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width: 800px; margin: 0 auto;">
    <div class="w3-card-4 w3-white">
        <header class="w3-container w3-green">
            <h2><i class="fas fa-user-plus"></i> Criar Novo Usuário</h2>
        </header>

        <form method="POST" action="index.php?action=usuario_criar" class="w3-container w3-padding-32">

            <div class="w3-section">
                <label class="w3-text-blue"><b>Nome Completo *</b></label>
                <input class="w3-input w3-border w3-round" type="text" name="nome" required
                    placeholder="Nome completo do usuário" value="<?php echo $_POST['nome'] ?? ''; ?>">
            </div>

            <div class="w3-row-padding">
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>Email *</b></label>
                        <input class="w3-input w3-border w3-round" type="email" name="email" required
                            placeholder="usuario@clinica.com" value="<?php echo $_POST['email'] ?? ''; ?>">
                    </div>
                </div>
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>CPF</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="cpf"
                            placeholder="000.000.000-00" value="<?php echo $_POST['cpf'] ?? ''; ?>">
                    </div>
                </div>
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Senha *</b></label>
                <input class="w3-input w3-border w3-round" type="password" name="senha" required
                    placeholder="Mínimo 6 caracteres">
                <small class="w3-text-grey">A senha deve ter pelo menos 6 caracteres</small>
            </div>

            <div class="w3-row-padding">
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>Telefone</b></label>
                        <input class="w3-input w3-border w3-round" type="tel" name="telefone"
                            placeholder="(11) 99999-9999" value="<?php echo $_POST['telefone'] ?? ''; ?>">
                    </div>
                </div>
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>Data de Nascimento</b></label>
                        <input class="w3-input w3-border w3-round" type="date" name="data_nascimento"
                            value="<?php echo $_POST['data_nascimento'] ?? ''; ?>">
                    </div>
                </div>
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Tipo de Usuário *</b></label>
                <select class="w3-select w3-border w3-round" name="tipo" required onchange="mostrarCamposMedico(this.value)">
                    <option value="">Selecione o tipo</option>
                    <option value="admin">Administrador</option>
                    <option value="medico">Médico</option>
                    <option value="secretaria">Secretária</option>
                    <option value="paciente">Paciente</option>
                </select>
            </div>

            <div id="camposMedico" style="display: none;">
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <div class="w3-section">
                            <label class="w3-text-blue"><b>CRM</b></label>
                            <input class="w3-input w3-border w3-round" type="text" name="crm"
                                placeholder="Número do CRM">
                        </div>
                    </div>
                    <div class="w3-half">
                        <div class="w3-section">
                            <label class="w3-text-blue"><b>Especialidade</b></label>
                            <input class="w3-input w3-border w3-round" type="text" name="especialidade"
                                placeholder="Especialidade médica">
                        </div>
                    </div>
                </div>
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Endereço</b></label>
                <textarea class="w3-input w3-border w3-round" name="endereco" rows="3"
                    placeholder="Endereço completo"><?php echo $_POST['endereco'] ?? ''; ?></textarea>
            </div>

            <div class="w3-bar w3-margin-top">
                <button type="submit" class="w3-button w3-green w3-large">
                    <i class="fas fa-save"></i> Criar Usuário
                </button>
                <a href="index.php?action=usuarios" class="w3-button w3-blue w3-large w3-right">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function mostrarCamposMedico(tipo) {
        const camposMedico = document.getElementById('camposMedico');
        if (tipo === 'medico') {
            camposMedico.style.display = 'block';
        } else {
            camposMedico.style.display = 'none';
        }
    }
</script>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>