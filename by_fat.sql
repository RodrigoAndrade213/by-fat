-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/11/2025 às 03:25
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `by_fat`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alimento`
--

CREATE TABLE `alimento` (
  `CODIGO` int(11) NOT NULL,
  `NOME` varchar(30) NOT NULL,
  `MEDIDA` varchar(20) NOT NULL,
  `UNIDADE` varchar(10) NOT NULL,
  `CALORIAS_POR_UNIDADE` decimal(10,2) NOT NULL
) ;

--
-- Despejando dados para a tabela `alimento`
--

INSERT INTO `alimento` (`CODIGO`, `NOME`, `MEDIDA`, `UNIDADE`, `CALORIAS_POR_UNIDADE`) VALUES
(1, 'Arroz', 'colher de sopa', 'gramas', 5.00),
(2, 'Chocolate', 'unidade', 'gramas', 50.00),
(3, 'Batata Frita', 'unidade', 'gramas', 5.00),
(4, 'Pure de Batata', 'colher de sopa', 'gramas', 5.00),
(5, 'Fígado', 'colher de sopa', 'gramas', 4.00),
(6, 'Feijão', 'concha', 'mililitros', 19.00),
(7, 'Ovo Frito', 'unidade', 'gramas', 27.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `refeicao`
--

CREATE TABLE `refeicao` (
  `CODIGO` int(9) NOT NULL,
  `DATA` date DEFAULT NULL,
  `TIPO` enum('Café da manhã','Almoço','Lanche da tarde','Jantar','Ceia') DEFAULT NULL,
  `ALIMENTO_CODIGO` int(11) NOT NULL,
  `QUANTIDADE` decimal(8,2) NOT NULL DEFAULT 1.00,
  `USUARIO_CODIGO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `refeicao`
--

INSERT INTO `refeicao` (`CODIGO`, `DATA`, `TIPO`, `ALIMENTO_CODIGO`, `QUANTIDADE`, `USUARIO_CODIGO`) VALUES
(1, '2025-07-15', 'Almoço', 0, 0.00, 1),
(2, '2025-07-15', 'Almoço', 0, 0.00, 1),
(3, '2025-07-15', 'Almoço', 0, 0.00, 1),
(4, '2025-07-15', 'Almoço', 0, 0.00, 1),
(5, '2025-07-15', 'Almoço', 0, 0.00, 1),
(6, '2204-11-25', 'Almoço', 0, 0.00, 1),
(8, '2022-11-22', 'Almoço', 3, 4.00, 9),
(9, '2023-07-15', 'Almoço', 4, 4.00, 9),
(10, '2022-11-10', 'Almoço', 1, 4.00, 10),
(11, '2024-11-10', 'Almoço', 6, 3.00, 10),
(12, '2025-11-17', 'Café da manhã', 4, 1.00, 10),
(13, '2025-11-17', 'Almoço', 3, 1.00, 9),
(14, '2025-11-17', 'Almoço', 2, 1.00, 9),
(15, '2025-11-17', 'Almoço', 4, 1.00, 9),
(16, '2025-11-17', 'Almoço', 2, 1.00, 9),
(18, '2025-11-17', 'Almoço', 1, 1.00, 12),
(19, '2025-11-17', 'Almoço', 6, 1.00, 12),
(20, '2025-11-17', 'Almoço', 5, 1.00, 12),
(21, '2025-11-17', 'Almoço', 4, 1.00, 12),
(22, '2025-11-17', 'Almoço', 3, 1.00, 12),
(23, '2025-11-17', 'Almoço', 2, 1.00, 12),
(24, '2025-11-17', 'Almoço', 5, 1.00, 12),
(25, '2025-11-21', 'Almoço', 1, 1.00, 12),
(26, '2025-11-21', 'Almoço', 3, 1.00, 12),
(27, '2025-11-21', 'Almoço', 1, 1.00, 12),
(28, '2025-11-21', 'Almoço', 4, 1.00, 12),
(29, '2025-11-21', 'Jantar', 1, 1.00, 12),
(30, '2025-11-21', 'Jantar', 6, 1.00, 12),
(31, '2025-11-21', 'Jantar', 5, 1.00, 12),
(32, '2025-11-21', 'Jantar', 4, 1.00, 12),
(33, '2025-11-23', 'Lanche da tarde', 7, 1.00, 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `CODIGO` int(11) NOT NULL,
  `NOME` varchar(30) NOT NULL,
  `IDADE` int(3) NOT NULL,
  `PESO` double(5,2) NOT NULL,
  `ALTURA` double(10,2) DEFAULT NULL,
  `IMC` double(5,2) DEFAULT NULL,
  `PESO_IDEAL` double(5,2) DEFAULT NULL,
  `SENHA` varchar(255) NOT NULL DEFAULT '',
  `EMAIL` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`CODIGO`, `NOME`, `IDADE`, `PESO`, `ALTURA`, `IMC`, `PESO_IDEAL`, `SENHA`, `EMAIL`) VALUES
(1, 'Joao', 25, 90.00, 165.00, 26.30, 76.25, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario1@byfat.com'),
(2, 'Ana', 35, 60.00, 165.00, 22.04, 61.25, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario2@byfat.com'),
(3, 'fernando', 55, 110.00, 165.00, 27.78, 86.75, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario3@byfat.com'),
(4, 'Carlos', 30, 85.00, 165.00, 29.76, 64.25, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario4@byfat.com'),
(5, 'Julia', 32, 65.00, 165.00, 23.03, 63.50, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario5@byfat.com'),
(6, 'Julia', 32, 65.00, 165.00, 23.03, 63.50, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario6@byfat.com'),
(7, 'Tieta', 32, 65.00, 165.00, 23.03, 63.50, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario7@byfat.com'),
(8, 'Vera', 32, 65.00, 169.00, 22.76, 64.25, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario8@byfat.com'),
(9, 'Daiane Diniz', 39, 97.00, 156.00, 39.86, 54.50, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario9@byfat.com'),
(10, 'Giovanna', 17, 65.00, 155.00, 27.06, 53.75, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario10@byfat.com'),
(11, 'Rodrigo de Andrade Silva', 43, 140.00, 170.00, 48.44, 65.00, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', ''),
(12, 'Rodrigo Silva', 42, 141.00, 170.00, NULL, NULL, '$2y$10$E/vBi7hBPwgQlOAqmflkB.c7.Fyg1cTSgih/FRGuyt7fIamQ0JcYe', 'rodrigo.andrade213@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alimento`
--
ALTER TABLE `alimento`
  ADD PRIMARY KEY (`CODIGO`);

--
-- Índices de tabela `refeicao`
--
ALTER TABLE `refeicao`
  ADD PRIMARY KEY (`CODIGO`),
  ADD KEY `USUARIO_CODIGO` (`USUARIO_CODIGO`),
  ADD KEY `fk_refeicao_alimento` (`ALIMENTO_CODIGO`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CODIGO`),
  ADD UNIQUE KEY `email_unique` (`EMAIL`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alimento`
--
ALTER TABLE `alimento`
  MODIFY `CODIGO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `refeicao`
--
ALTER TABLE `refeicao`
  MODIFY `CODIGO` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `CODIGO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `refeicao`
--
ALTER TABLE `refeicao`
  ADD CONSTRAINT `fk_refeicao_alimento` FOREIGN KEY (`ALIMENTO_CODIGO`) REFERENCES `alimento` (`CODIGO`) ON UPDATE CASCADE,
  ADD CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`USUARIO_CODIGO`) REFERENCES `usuario` (`CODIGO`),
  ADD CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`ALIMENTO_CODIGO`) REFERENCES `alimento` (`CODIGO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
