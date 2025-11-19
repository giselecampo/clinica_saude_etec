<?php $titulo = "Gerenciar Usuários - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-users"></i> Gerenciar Usuários</b></h1>

    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=admin" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="index.php?action=usuario_criar" class="w3-button w3-green w3-right">
            <i class="fas fa-user-plus"></i> Novo Usuário
        </a>
    </div>

    <div class="w3-card-4">
        <header class="w3-container w3-blue">
            <h3><i class="fas fa-list"></i> Lista de Usuários do Sistema</h3>
        </header>
        <div class="w3-container">
            <?php if ($dados['usuarios'] && $dados['usuarios']->rowCount() > 0): ?>
                <table class="w3-table w3-striped w3-bordered w3-hoverable">
                    <thead>
                        <tr class="w3-light-grey">
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($usuario = $dados['usuarios']->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($usuario['nome']); ?></strong>
                                    <?php if ($usuario['crm']): ?>
                                        <br><small class="w3-text-grey">CRM: <?php echo $usuario['crm']; ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['cpf']); ?></td>
                                <td>
                                    <span class="w3-tag w3-<?php
                                                            echo $usuario['tipo'] == 'admin' ? 'red' : ($usuario['tipo'] == 'medico' ? 'teal' : ($usuario['tipo'] == 'secretaria' ? 'orange' : 'blue'));
                                                            ?>">
                                        <?php echo ucfirst($usuario['tipo']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="w3-tag w3-<?php echo $usuario['ativo'] ? 'green' : 'red'; ?>">
                                        <?php echo $usuario['ativo'] ? 'Ativo' : 'Inativo'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?action=usuario_editar&id=<?php echo $usuario['id']; ?>"
                                        class="w3-button w3-blue w3-tiny">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="index.php?action=usuario_excluir&id=<?php echo $usuario['id']; ?>"
                                        class="w3-button w3-red w3-tiny" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="w3-padding-32 w3-center">
                    <i class="fas fa-users w3-xxlarge w3-text-grey"></i>
                    <p class="w3-large w3-text-grey">Nenhum usuário cadastrado</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>