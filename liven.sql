-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Jul-2024 às 21:12
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `liven`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(100) NOT NULL,
  `number` varchar(10) NOT NULL,
  `complement` varchar(50) DEFAULT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `address`
--

INSERT INTO `address` (`id`, `user_id`, `street`, `number`, `complement`, `neighborhood`, `city`, `state`, `zip_code`, `country`) VALUES
(1, 11, 'Rua Anhanguera', '273', NULL, 'Centro', 'São José do Rio Pardo', 'SP', '13720000', 'BR'),
(2, 11, 'Rua Alterada', '111', NULL, 'Centro', 'São José do Rio Pardo', 'SP', '13720000', 'BR'),
(10, 11, 'Rua Crystal', '2369', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(12, 11, 'Rua Alterada15', '111', 'Ap', 'Cassuci', 'São José do Rio Pardo', 'SP', '13720000', 'BR'),
(13, 11, 'Rua Sparta', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(14, 11, 'Rua BloodyAxe', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(15, 11, 'Rua Teste Liven', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'UK'),
(16, 11, 'Rua Teste Liven5', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(17, 11, 'Rua Teste Liven', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(18, 11, 'Rua Teste Liven', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(19, 11, 'Rua Teste Liven', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(20, 11, 'Rua Teste Liven', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(21, 11, 'Rua Teste Liven', '11111', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(22, 11, 'Rua Teste Automatizado', '3333', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(23, 11, 'Rua Teste Automatizado2', '3333', 'Apartamento', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(27, 11, 'Rua Teste Liven21', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(33, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(34, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(35, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(36, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(37, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(38, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(39, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(40, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(41, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(42, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(43, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(44, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(45, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(46, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(47, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(48, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(49, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(50, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(51, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(52, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(54, 11, 'Rua Teste Liven22', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(71, 11, 'Rua Teste Liven23', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(72, 11, 'Rua Teste Liven23', '11111', 'Ap', 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(73, 78, 'Rua Teste Brasil', '9696', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(74, 78, 'Rua testeUK_Alterada', '111', NULL, 'Cassuci', 'São José do Rio Pardo', 'SP', '13720000', 'UK'),
(75, 78, 'Rua Teste UK2', '9696', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'UK'),
(76, 79, 'Rua testeUK_Alterada', '111', NULL, 'Cassuci', 'São José do Rio Pardo', 'SP', '13720000', 'UK'),
(77, 79, 'Rua Teste BR', '9696', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR'),
(78, 79, 'Rua Teste BR', '9696', NULL, 'Centro', 'Campinas', 'SP', '13840000', 'BR');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'FernandoALTERADO', '123456', 'fernando@gmail.com', '2024-06-26 19:01:48', '2024-06-27 18:13:27', 1),
(2, 'Gabriela', '123', 'gabriela@gmail.com', '2024-06-27 17:00:38', '2024-06-27 17:00:38', 1),
(5, 'Exemplo Alterado', 'SenhaAlterada', 'email@alterado.com.br', '2024-06-27 17:03:38', '2024-06-28 00:24:28', 1),
(6, 'Teste HASH', '$2y$10$z3iyZjf8tZrGq26dVwvSWexiINM0oaMo8xqwHaLHL25scuJFtf67.', 'teste@ok.com.br', '2024-06-27 19:37:50', '2024-06-27 19:37:50', 1),
(9, 'Renata_TOKEN', '$2y$10$gBTSWdcs9L.8oNCiusRfAeSWqbZCcxtX4mC21I7w4408qwkKa1xdO', 'renata_tk@gmail.com', '2024-06-28 00:26:37', '2024-06-28 00:26:37', 1),
(11, 'RenataLiven', '$2y$10$QGHdTciTcTZQsZKYxyds/eaT52rLlOiHhBa6EtToadAAmC2J2txHK', 'renata_alterada3@gmail.com', '2024-06-28 18:59:13', '2024-06-30 21:57:19', 1),
(12, 'FernandoTeste3', '$2y$10$at3nS4RsmQ6fyaLmjdk7q.w9GDxxkvIqqiKhd1zG6ua9l88gO4q66', 'renataliven@gmail.com', '2024-06-29 18:23:01', '2024-06-29 18:23:01', 1),
(13, 'FernandoTeste5', '$2y$10$7Acus1/yT0dsvsXq1v57vOPPycMd4wBaRSdRUTozTXOpzvX0TbIyO', 'fernandoandrade@gmail.com', '2024-06-30 13:57:04', '2024-06-30 13:57:04', 1),
(76, 'FernandoTeste20', '$2y$10$74avMHTIPORt.p0Q/b9.luAqJ7QW6EppDDZh6EeWQu/il52Vh113W', 'fernandoandrade20@gmail.com', '2024-06-30 21:57:19', '2024-06-30 21:57:19', 1),
(78, 'FernandoTesteLivenAlterado2', '$2y$10$VOe6SlqUgBBCPGv.pyHMv.LiO0EuDPL6VCy0tAPJGQ/FJ1L/ciLUq', 'testealteradolivenalt2@gmail.com', '2024-07-01 17:32:16', '2024-07-02 16:55:24', 1),
(79, 'FernandoTesteLivenAlterado93', '$2y$10$Yh/Lri.pFDRxD15bchlR/uRpQ2dIpKs.k9ySr9zD7YPvXfOF7bd7K', 'testealteradolivenalt9@gmail.com', '2024-07-02 10:53:04', '2024-07-02 17:36:58', 1),
(80, 'FernandoTesteLiven6', '$2y$10$5KKAfWDONLDluzZtNsY0aOVQnYBjIF4KmRtMwqFcjXM81RXX.OaXm', 'testeliven6@gmail.com', '2024-07-02 16:39:41', '2024-07-02 16:39:41', 1),
(81, 'FernandoTeste264', '$2y$10$ateK/ukusfP70GMsTkmFheGK2KqnMUSaorXn9B/2uE1y.oerI4M7a', 'fernandoandrade264@gmail.com', '2024-07-02 19:00:36', '2024-07-02 19:00:36', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
