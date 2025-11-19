-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306:3306
-- Tempo de geração: 08-Nov-2025 às 22:22
-- Versão do servidor: 5.7.36
-- versão do PHP: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clinica_saude`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `data_consulta` datetime NOT NULL,
  `tipo_consulta` varchar(50) DEFAULT NULL,
  `observacoes` text,
  `status` enum('agendada','realizada','cancelada') DEFAULT 'agendada',
  `diagnostico` text,
  `prescricao` text,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id`, `paciente_id`, `medico_id`, `data_consulta`, `tipo_consulta`, `observacoes`, `status`, `diagnostico`, `prescricao`, `data_criacao`) VALUES
(1, 1, 2, '2024-01-15 09:00:00', 'Consulta de rotina', 'Paciente com queixa de dor no peito', 'realizada', NULL, NULL, '2025-11-08 15:46:25'),
(2, 2, 3, '2024-01-15 10:30:00', 'Acompanhamento pediátrico', 'Controle de crescimento', 'realizada', NULL, NULL, '2025-11-08 15:46:25'),
(3, 3, 4, '2024-01-15 14:00:00', 'Avaliação ortopédica', 'Dor no joelho direito', 'realizada', NULL, NULL, '2025-11-08 15:46:25'),
(4, 1, 2, '2024-01-20 08:30:00', 'Retorno', 'Avaliação do tratamento', 'agendada', NULL, NULL, '2025-11-08 15:46:25'),
(5, 4, 3, '2024-01-20 11:00:00', 'Consulta pré-natal', 'Primeira consulta', 'agendada', NULL, NULL, '2025-11-08 15:46:25'),
(6, 5, 4, '2024-01-20 15:30:00', 'Avaliação inicial', 'Queixa de dor nas costas', 'agendada', NULL, NULL, '2025-11-08 15:46:25'),
(7, 2, 2, '2024-01-22 09:30:00', 'Consulta cardiológica', 'Check-up anual', 'agendada', NULL, NULL, '2025-11-08 15:46:25'),
(8, 4, 2, '2025-11-08 13:46:25', 'Consulta de rotina', 'Paciente em acompanhamento', 'agendada', NULL, NULL, '2025-11-08 15:46:25'),
(9, 5, 3, '2025-11-08 14:46:25', 'Avaliação inicial', 'Primeira consulta na clínica', 'agendada', NULL, NULL, '2025-11-08 15:46:25'),
(10, 1, 4, '2025-11-08 15:46:25', 'Retorno ortopédico', 'Avaliação pós-fisioterapia', 'agendada', NULL, NULL, '2025-11-08 15:46:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `exames`
--

CREATE TABLE `exames` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `tipo_exame` varchar(100) NOT NULL,
  `data_solicitacao` date NOT NULL,
  `data_realizacao` date DEFAULT NULL,
  `resultado` text,
  `status` enum('solicitado','realizado','cancelado') DEFAULT 'solicitado',
  `observacoes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `exames`
--

INSERT INTO `exames` (`id`, `paciente_id`, `medico_id`, `tipo_exame`, `data_solicitacao`, `data_realizacao`, `resultado`, `status`, `observacoes`) VALUES
(1, 1, 2, 'Eletrocardiograma', '2024-01-15', '2024-01-16', 'Ritmo sinusal normal, sem alterações', 'realizado', 'Exame dentro da normalidade'),
(2, 1, 2, 'Hemograma completo', '2024-01-15', NULL, NULL, 'solicitado', 'Aguardando realização'),
(3, 3, 4, 'Radiografia do joelho', '2024-01-15', '2024-01-17', 'Sem fraturas, pequeno desgaste cartilaginoso', 'realizado', 'Recomendado fisioterapia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `convenio` varchar(50) DEFAULT NULL,
  `numero_convenio` varchar(50) DEFAULT NULL,
  `contato_emergencia` varchar(100) DEFAULT NULL,
  `telefone_emergencia` varchar(15) DEFAULT NULL,
  `alergias` text,
  `medicamentos_uso` text,
  `historico_familiar` text,
  `observacoes` text,
  `data_nascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `usuario_id`, `convenio`, `numero_convenio`, `contato_emergencia`, `telefone_emergencia`, `alergias`, `medicamentos_uso`, `historico_familiar`, `observacoes`, `data_nascimento`) VALUES
(1, 6, 'Unimed', 'UMD123456789', 'Joana Oliveira', '(11) 98888-1111', 'Penicilina, Dipirona', 'Losartana 50mg - 1x dia', 'Hipertensão, Diabetes', 'Paciente com histórico familiar de hipertensão', NULL),
(2, 7, 'Bradesco Saúde', 'BRD987654321', 'José Silva', '(11) 98888-2222', 'Não possui', 'Anticoncepcional', 'Cancer de mama (avó)', 'Fazer acompanhamento anual', '1985-05-15'),
(3, 8, 'Amil', 'AML555444333', 'Maria Alves', '(11) 98888-3333', 'Pocecão, Mariscos', 'Nenhum', 'Asma, Rinite', 'Pratica atividades físicas regularmente', '1990-08-22'),
(4, 9, 'SulAmérica', 'SAM111222333', 'Carlos Lima', '(11) 98888-4444', 'Iodo', 'Vitamina D 1000UI', 'Osteoporose (mãe)', 'Vegetariana há 5 anos', '1978-12-03'),
(5, 10, 'Particular', NULL, 'Ana Mendes', '(11) 98888-5555', 'Não possui', 'Nenhum', 'Não relata', 'Paciente saudável', '1995-03-18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prontuarios`
--

CREATE TABLE `prontuarios` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `sintomas` text,
  `diagnostico` text,
  `prescricao` text,
  `observacoes` text,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prontuarios`
--

INSERT INTO `prontuarios` (`id`, `paciente_id`, `medico_id`, `data_consulta`, `sintomas`, `diagnostico`, `prescricao`, `observacoes`, `data_criacao`) VALUES
(1, 1, 2, '2024-01-15', 'Dor precordial, palpitações, falta de ar', 'Arritmia cardíaca benigna', 'Propranolol 40mg 12/12h por 30 dias', 'Encaminhar para ecocardiograma', '2025-11-08 15:46:25'),
(2, 2, 3, '2024-01-15', 'Controle de crescimento e desenvolvimento', 'Desenvolvimento dentro da normalidade', 'Suplementação de vitamina D', 'Retorno em 6 meses', '2025-11-08 15:46:25'),
(3, 3, 4, '2024-01-15', 'Dor no joelho direito ao flexionar', 'Tendinite patelar', 'Anti-inflamatório por 7 dias, repouso relativo', 'Encaminhar para fisioterapia', '2025-11-08 15:46:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `endereco` text,
  `tipo` enum('admin','medico','secretaria','paciente') NOT NULL,
  `crm` varchar(20) DEFAULT NULL,
  `especialidade` varchar(50) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cpf`, `telefone`, `data_nascimento`, `endereco`, `tipo`, `crm`, `especialidade`, `ativo`, `data_criacao`) VALUES
(1, 'Administrador', 'admin@clinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, 1, '2025-11-08 15:46:25'),
(2, 'Dr. João Silva', 'joao.silva@clinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-01', '(11) 99999-1001', NULL, NULL, 'medico', 'SP-123456', 'Cardiologia', 1, '2025-11-08 15:46:25'),
(3, 'Dra. Maria Santos', 'maria.santos@clinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-02', '(11) 99999-1002', NULL, NULL, 'medico', 'SP-123457', 'Pediatria', 1, '2025-11-08 15:46:25'),
(4, 'Dr. Pedro Costa', 'pedro.costa@clinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-03', '(11) 99999-1003', NULL, NULL, 'medico', 'SP-123458', 'Ortopedia', 1, '2025-11-08 15:46:25'),
(5, 'Ana Oliveira', 'ana.oliveira@clinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-04', '(11) 99999-1004', NULL, NULL, 'secretaria', NULL, NULL, 1, '2025-11-08 15:46:25'),
(6, 'Carlos Souza', 'carlos.souza@clinica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-05', '(11) 99999-1005', NULL, NULL, 'secretaria', NULL, NULL, 1, '2025-11-08 15:46:25'),
(7, 'Carlos Oliveira', 'carlos@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-06', '(11) 99999-1006', '1985-05-15', 'Rua das Flores, 123 - Centro - São Paulo/SP', 'paciente', NULL, NULL, 1, '2025-11-08 15:46:25'),
(8, 'Mariana Silva', 'mariana@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-07', '(11) 99999-1007', '1990-08-22', 'Av. Paulista, 1000 - Bela Vista - São Paulo/SP', 'paciente', NULL, NULL, 1, '2025-11-08 15:46:25'),
(9, 'Roberto Alves', 'roberto@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-08', '(11) 99999-1008', '1978-12-03', 'Rua Augusta, 500 - Consolação - São Paulo/SP', 'paciente', NULL, NULL, 1, '2025-11-08 15:46:25'),
(10, 'Fernanda Lima', 'fernanda@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-09', '(11) 99999-1009', '1995-03-18', 'Rua XV de Novembro, 200 - Centro - São Paulo/SP', 'paciente', NULL, NULL, 1, '2025-11-08 15:46:25'),
(11, 'Paulo Mendes', 'paulo@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '123.456.789-10', '(11) 99999-1010', '1982-07-30', 'Alameda Santos, 800 - Jardins - São Paulo/SP', 'paciente', NULL, NULL, 1, '2025-11-08 15:46:25');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Índices para tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `prontuarios`
--
ALTER TABLE `prontuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `prontuarios`
--
ALTER TABLE `prontuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `exames`
--
ALTER TABLE `exames`
  ADD CONSTRAINT `exames_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  ADD CONSTRAINT `exames_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `prontuarios`
--
ALTER TABLE `prontuarios`
  ADD CONSTRAINT `prontuarios_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  ADD CONSTRAINT `prontuarios_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
