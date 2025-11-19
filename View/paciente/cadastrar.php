<?php $titulo = "Cadastrar Paciente - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width: 800px; margin: 0 auto;">
    <div class="w3-card-4 w3-white">
        <header class="w3-container w3-green">
            <h2><i class="fas fa-user-plus"></i> Cadastrar Novo Paciente</h2>
        </header>

        <form method="POST" action="index.php?action=paciente_cadastrar" class="w3-container w3-padding-32">
            
            <fieldset class="w3-padding-16">
                <legend class="w3-large w3-text-blue"><i class="fas fa-user"></i> Dados Pessoais</legend>
                
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>Nome Completo *</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="nome" required 
                               placeholder="Nome completo do paciente">
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>CPF *</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="cpf" required 
                               placeholder="000.000.000-00">
                    </div>
                </div>

                <div class="w3-row-padding w3-margin-top">
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>Data de Nascimento</b></label>
                        <input class="w3-input w3-border w3-round" type="date" name="data_nascimento">
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-blue"><b>Telefone</b></label>
                        <input class="w3-input w3-border w3-round" type="tel" name="telefone" 
                               placeholder="(11) 99999-9999">
                    </div>
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-blue"><b>Email *</b></label>
                    <input class="w3-input w3-border w3-round" type="email" name="email" required 
                           placeholder="paciente@email.com">
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-blue"><b>Endereço</b></label>
                    <textarea class="w3-input w3-border w3-round" name="endereco" rows="3" 
                              placeholder="Endereço completo"></textarea>
                </div>
            </fieldset>

            <fieldset class="w3-padding-16">
                <legend class="w3-large w3-text-green"><i class="fas fa-heartbeat"></i> Dados Médicos</legend>
                
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <label class="w3-text-green"><b>Convênio</b></label>
                        <select class="w3-select w3-border w3-round" name="convenio">
                            <option value="">Selecione o convênio</option>
                            <option value="Amil">Amil</option>
                            <option value="Bradesco Saúde">Bradesco Saúde</option>
                            <option value="SulAmérica">SulAmérica</option>
                            <option value="Unimed">Unimed</option>
                            <option value="Particular">Particular</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-green"><b>Número do Convênio</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="numero_convenio" 
                               placeholder="Número da carteirinha">
                    </div>
                </div>

                <div class="w3-row-padding w3-margin-top">
                    <div class="w3-half">
                        <label class="w3-text-green"><b>Contato de Emergência</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="contato_emergencia" 
                               placeholder="Nome do contato">
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-green"><b>Telefone Emergencial</b></label>
                        <input class="w3-input w3-border w3-round" type="tel" name="telefone_emergencia" 
                               placeholder="(11) 99999-9999">
                    </div>
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-green"><b>Alergias Conhecidas</b></label>
                    <textarea class="w3-input w3-border w3-round" name="alergias" rows="2" 
                              placeholder="Lista de alergias (separar por vírgula)"></textarea>
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-green"><b>Medicamentos em Uso</b></label>
                    <textarea class="w3-input w3-border w3-round" name="medicamentos_uso" rows="2" 
                              placeholder="Medicamentos de uso contínuo"></textarea>
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-green"><b>Histórico Familiar</b></label>
                    <textarea class="w3-input w3-border w3-round" name="historico_familiar" rows="2" 
                              placeholder="Doenças hereditárias na família"></textarea>
                </div>

                <div class="w3-margin-top">
                    <label class="w3-text-green"><b>Observações</b></label>
                    <textarea class="w3-input w3-border w3-round" name="observacoes" rows="3" 
                              placeholder="Outras observações importantes"></textarea>
                </div>
            </fieldset>

            <div class="w3-bar w3-margin-top">
                <button type="submit" class="w3-button w3-green w3-large">
                    <i class="fas fa-save"></i> Cadastrar Paciente
                </button>
                <a href="index.php?action=pacientes" class="w3-button w3-blue w3-large w3-right">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>