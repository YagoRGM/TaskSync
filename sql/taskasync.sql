-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Maio-2025 às 19:06
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `taskasync`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id_tarefa` int(11) NOT NULL,
  `titulo_tarefa` varchar(30) NOT NULL,
  `descricao_tarefa` varchar(50) NOT NULL,
  `status_tarefa` enum('fazer','fazendo','concluido') NOT NULL,
  `prioridade` enum('baixa','media','alta') NOT NULL,
  `data_tarefa` date NOT NULL DEFAULT current_timestamp(),
  `setor` varchar(30) NOT NULL,
  `fk_id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tarefas`
--

INSERT INTO `tarefas` (`id_tarefa`, `titulo_tarefa`, `descricao_tarefa`, `status_tarefa`, `prioridade`, `data_tarefa`, `setor`, `fk_id_usuario`) VALUES
(4, 'Tarefa1', 'tarefa primeira vamos', 'fazer', 'baixa', '2025-05-07', 'Testando', 1),
(5, 'Tarefa2', 'tarefa primeira vamos', 'fazendo', 'alta', '2025-05-12', 'Testando', 1),
(6, 'Tarefa4', 'tarefa 4vamos', 'concluido', 'baixa', '2025-05-19', 'Testando', 1),
(7, 'Tarefa5', 'tarefa 5 vamos', 'fazer', 'media', '2025-05-13', 'Testando', 1),
(9, 'Turma da Monica', 'editando', 'concluido', 'baixa', '2025-05-20', 'editando', 1),
(12, 'tarefa do teste', 'testeeeee', 'fazer', 'baixa', '2025-05-20', 'Testando', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(30) NOT NULL,
  `senha_usuario` varchar(260) NOT NULL,
  `email_usuario` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `senha_usuario`, `email_usuario`) VALUES
(1, 'Yago', '$2y$10$V9/ng75uZmxom4r5OB3ne.Z/gAzi3II0jCbev3DiZjPSwCJ2gHpWS', 'yago@gmail.com'),
(2, 'Teste', '$2y$10$gPXLxB6SH7K3FWdu9PyZCO9Bhfx3XmJJoqdOgRllMBYwtAQr4UEkW', 'teset@gmail.com'),
(3, 'aa', '$2y$10$29agW8RjNDW9Hgw7WrI2Ee.O1aITtc9WJvYq/L4FVtY5vtPpxtu6S', 'a@a'),
(4, 'Yago', '$2y$10$DE8LibfELcYm2k2xl0iuc.VCraSUCY0EzwksROyx31Vby4wVh8Opm', 'a@dfsds'),
(5, 'Professor', '$2y$10$qY6QtN7KYuZk7WnUa65RP.EgQ032TjXrg3BoJP1nfRurqF9eKMe/u', 'prof@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id_tarefa`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id_tarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
