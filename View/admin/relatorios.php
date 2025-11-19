<?php $titulo = "Relatórios - Clínica de Saúde"; ?>
<?php require_once ROOT_PATH . 'View/templates/header.php'; ?>

<div class="w3-container">
    <h1 class="w3-xxlarge"><b><i class="fas fa-chart-bar"></i> Relatórios do Sistema</b></h1>

    <div class="w3-bar w3-margin-bottom">
        <a href="index.php?action=admin" class="w3-button w3-blue">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Cards de Estatísticas -->
    <!-- Cards de Estatísticas -->
    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-third">
            <div class="w3-card-4 w3-blue w3-padding-16 w3-center">
                <h3>Total de Usuários</h3>
                <h2>
                    <?php
                    if (isset($dados['estatisticas']['usuarios_por_tipo'])) {
                        $total = 0;
                        foreach ($dados['estatisticas']['usuarios_por_tipo'] as $tipo) {
                            $total += $tipo['total'];
                        }
                        echo $total;
                    } else {
                        echo '0';
                    }
                    ?>
                </h2>
            </div>
        </div>
        <div class="w3-third">
            <div class="w3-card-4 w3-green w3-padding-16 w3-center">
                <h3>Total de Pacientes</h3>
                <h2>
                    <?php
                    echo $dados['estatisticas']['pacientes']['total_pacientes'] ?? '0';
                    ?>
                </h2>
            </div>
        </div>
        <div class="w3-third">
            <div class="w3-card-4 w3-teal w3-padding-16 w3-center">
                <h3>Consultas/Mês</h3>
                <h2>
                    <?php
                    if (isset($dados['estatisticas']['consultas_por_mes'])) {
                        $total = 0;
                        foreach ($dados['estatisticas']['consultas_por_mes'] as $mes) {
                            $total += $mes['total'];
                        }
                        echo $total;
                    } else {
                        echo '0';
                    }
                    ?>
                </h2>
            </div>
        </div>
    </div>
    <h2><?php echo $dados['estatisticas']['pacientes']['total_pacientes']; ?></h2>
</div>
</div>
<div class="w3-third">
    <div class="w3-card-4 w3-teal w3-padding-16 w3-center">
        <h3>Consultas/Mês</h3>
        <h2><?php echo array_sum(array_column($dados['estatisticas']['consultas_por_mes'], 'total')); ?></h2>
    </div>
</div>
</div>

<!-- Relatórios Disponíveis -->
<div class="w3-row-padding">
    <div class="w3-third">
        <div class="w3-card-4 w3-hover-shadow">
            <header class="w3-container w3-blue">
                <h3><i class="fas fa-user-injured"></i> Relatório de Pacientes</h3>
            </header>
            <div class="w3-container w3-padding-16">
                <p>Relatório completo com todos os pacientes cadastrados, convênios e estatísticas.</p>
                <button onclick="gerarRelatorio('pacientes')" class="w3-button w3-blue w3-block">
                    <i class="fas fa-download"></i> Gerar Relatório
                </button>
            </div>
        </div>
    </div>

    <div class="w3-third">
        <div class="w3-card-4 w3-hover-shadow">
            <header class="w3-container w3-green">
                <h3><i class="fas fa-calendar-alt"></i> Relatório de Consultas</h3>
            </header>
            <div class="w3-container w3-padding-16">
                <p>Relatório com todas as consultas agendadas, realizadas e canceladas.</p>
                <button onclick="gerarRelatorio('consultas')" class="w3-button w3-green w3-block">
                    <i class="fas fa-download"></i> Gerar Relatório
                </button>
            </div>
        </div>
    </div>

    <div class="w3-third">
        <div class="w3-card-4 w3-hover-shadow">
            <header class="w3-container w3-purple">
                <h3><i class="fas fa-money-bill-wave"></i> Relatório Financeiro</h3>
            </header>
            <div class="w3-container w3-padding-16">
                <p>Relatório financeiro com receitas, despesas e lucro da clínica.</p>
                <button onclick="gerarRelatorio('financeiro')" class="w3-button w3-purple w3-block">
                    <i class="fas fa-download"></i> Gerar Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Área de Resultados -->
<div id="resultadoRelatorio" class="w3-margin-top" style="display: none;">
    <div class="w3-card-4">
        <header class="w3-container w3-orange">
            <h3><i class="fas fa-file-alt"></i> Resultado do Relatório</h3>
        </header>
        <div class="w3-container w3-padding-16" id="conteudoRelatorio">
            <!-- Conteúdo do relatório será carregado aqui -->
        </div>
    </div>
</div>
</div>

<script>
    function gerarRelatorio(tipo) {
        // Mostrar loading
        document.getElementById('conteudoRelatorio').innerHTML = '<p class="w3-center"><i class="fas fa-spinner fa-spin"></i> Gerando relatório...</p>';
        document.getElementById('resultadoRelatorio').style.display = 'block';

        fetch(`index.php?action=relatorio_gerar&tipo=${tipo}`)
            .then(response => response.json())
            .then(data => {
                let html = `
                <h4>Relatório de ${data.tipo.toUpperCase()}</h4>
                <p><strong>Data de geração:</strong> ${data.data_geracao}</p>
                <p><strong>Total de registros:</strong> ${data.total_registros}</p>
                
                <h5>Estatísticas:</h5>
                <div class="w3-responsive">
            `;

                if (tipo === 'pacientes') {
                    html += `
                    <p>Total de Pacientes: ${data.estatisticas.total_pacientes}</p>
                    <p>Novos este mês: ${data.estatisticas.novos_este_mes}</p>
                    <p>Com convênio: ${data.estatisticas.pacientes_por_convenio.reduce((acc, item) => acc + item.total, 0)}</p>
                `;
                } else if (tipo === 'consultas') {
                    html += `
                    <p>Consultas Agendadas: ${data.estatisticas.agendadas}</p>
                    <p>Consultas Realizadas: ${data.estatisticas.realizadas}</p>
                    <p>Consultas Canceladas: ${data.estatisticas.canceladas}</p>
                `;
                } else if (tipo === 'financeiro') {
                    html += `
                    <p>Receita Mensal: ${data.receita_mensal}</p>
                    <p>Despesas Mensais: ${data.despesas_mensais}</p>
                    <p>Lucro Líquido: ${data.lucro_liquido}</p>
                    <p>Consultas este mês: ${data.consultas_este_mes}</p>
                `;
                }

                html += `</div>`;

                document.getElementById('conteudoRelatorio').innerHTML = html;
            })
            .catch(error => {
                document.getElementById('conteudoRelatorio').innerHTML = '<p class="w3-text-red">Erro ao gerar relatório: ' + error + '</p>';
            });
    }
</script>

<?php require_once ROOT_PATH . 'View/templates/footer.php'; ?>