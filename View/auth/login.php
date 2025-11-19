<?php $titulo = "Login - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container" style="max-width: 500px; margin: 50px auto;">
    <div class="w3-card-4 w3-white w3-padding-32">
        <div class="w3-center">
            <i class="fas fa-sign-in-alt w3-xxlarge w3-text-blue"></i>
            <h2>Acessar Sistema</h2>
            <p>Entre com suas credenciais</p>
        </div>

        <form method="POST" action="index.php?action=login">
            <div class="w3-section">
                <label class="w3-text-blue"><b>Email</b></label>
                <input class="w3-input w3-border w3-round" type="email" name="email" required 
                       placeholder="seu@email.com" value="<?php echo $_POST['email'] ?? ''; ?>">
            </div>

            <div class="w3-section">
                <label class="w3-text-blue"><b>Senha</b></label>
                <input class="w3-input w3-border w3-round" type="password" name="senha" required 
                       placeholder="Sua senha">
            </div>

            <div class="w3-section">
                <button type="submit" class="w3-button w3-blue w3-block w3-round w3-large">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </div>

            <div class="w3-center w3-padding-16">
                <p>Não tem uma conta? 
                    <a href="index.php?action=registro" class="w3-text-blue">
                        <b>Cadastre-se aqui</b>
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>