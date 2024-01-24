-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Jan-2024 às 06:25
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
-- Banco de dados: `rpg`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `charactercard`
--

CREATE TABLE `charactercard` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idTable` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `characterData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`characterData`)),
  `characterPDF` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `members`
--

CREATE TABLE `members` (
  `idUser` int(11) NOT NULL,
  `idTable` int(11) NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tables`
--

CREATE TABLE `tables` (
  `idTable` int(11) NOT NULL,
  `nameTable` varchar(100) DEFAULT NULL,
  `descriptionTable` varchar(255) DEFAULT NULL,
  `passwordTable` varchar(255) DEFAULT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `codeTable` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `usernameUser` varchar(100) NOT NULL,
  `emailUser` varchar(255) NOT NULL,
  `passwordUser` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`idUser`, `usernameUser`, `emailUser`, `passwordUser`) VALUES
(3, 'Ghashie', 'teste@gmail.com', '$2y$10$CraoPTkqB4AJC86hX.y88OLw2pwEkAgc.xhudLSBgyaGAjgFDY1xe'),
(4, 'Yugi', 'yugi@gmail.com', '$2y$10$rlJiXsMlODC7v4Hiu4bVwuqit2jFTA8.YOhEki8AhV.WWYgCn1XvG');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `charactercard`
--
ALTER TABLE `charactercard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idTable` (`idTable`);

--
-- Índices para tabela `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`idUser`,`idTable`),
  ADD KEY `idTable` (`idTable`) USING BTREE;

--
-- Índices para tabela `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`idTable`),
  ADD UNIQUE KEY `codeTable` (`codeTable`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `charactercard`
--
ALTER TABLE `charactercard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tables`
--
ALTER TABLE `tables`
  MODIFY `idTable` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `charactercard`
--
ALTER TABLE `charactercard`
  ADD CONSTRAINT `charactercard_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `charactercard_ibfk_2` FOREIGN KEY (`idTable`) REFERENCES `tables` (`idTable`);

--
-- Limitadores para a tabela `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`idTable`) REFERENCES `tables` (`idTable`);

--
-- Limitadores para a tabela `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
