<?php $titulo = "Cadastro - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width: 600px; margin: 50px auto;">
    <div class="w3-card-4 w3-white w3-padding-32">
        <div class="w3-center">
            <i class="fas fa-user-plus w3-xxlarge w3-text-blue"></i>
            <h2>Criar Minha Conta</h2>
            <p>Cadastre-se como paciente</p>
        </div>

        <form method="POST" action="index.php?action=registro">
            <div class="w3-section">
                <label class="w3-text-blue"><b>Nome Completo *</b></label>
                <input class="w3-input w3-border w3-round" type="text" name="nome" required 
                       placeholder="Seu nome completo" value="<?php echo $_POST['nome'] ?? ''; ?>">
            </div>

            <div class="w3-row-padding">
                <div class="w3-half">
                    <div class="w3-section">
                        <label class="w3-text-blue"><b>CPF *</b></label>
                        <input class="w3-input w3-border w3-round" type="text" name="cpf" required 
                               placeholder="000.000.000-00" value="<?php echo $_POST['cpf'] ?? ''; ?>">
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
                <label class="w3-text-blue"><b>Email *</b></label>
                <input class="w3-input w3-border w3-round" type="email" name="email" required 
                       placeholder="seu@email.com" value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Telefone</b></label>
                <input class="w3-input w3-border w3-round" type="tel" name="telefone" 
                       placeholder="(11) 99999-9999" value="<?php echo $_POST['telefone'] ?? ''; ?>">
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Endereço</b></label>
                <textarea class="w3-input w3-border w3-round" name="endereco" rows="3" 
                          placeholder="Seu endereço completo"><?php echo $_POST['endereco'] ?? ''; ?></textarea>
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Senha *</b></label>
                <input class="w3-input w3-border w3-round" type="password" name="senha" required 
                       placeholder="Mínimo 6 caracteres">
                <small class="w3-text-grey">A senha deve ter pelo menos 6 caracteres</small>
            </div>

            <div class="w3-section">
                <button type="submit" class="w3-button w3-blue w3-block w3-round w3-large">
                    <i class="fas fa-user-plus"></i> Criar Minha Conta
                </button>
            </div>

            <div class="w3-center w3-padding-16">
                <p>Já tem uma conta? 
                    <a href="index.php?action=login" class="w3-text-blue">
                        <b>Faça login aqui</b>
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>