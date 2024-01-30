-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Jan-2024 às 15:49
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
  `idCharacter` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idTable` int(11) NOT NULL,
  `characterPDF` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `members`
--

CREATE TABLE `members` (
  `idUser` int(11) NOT NULL,
  `idTable` int(11) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `members`
--

INSERT INTO `members` (`idUser`, `idTable`, `isAdmin`) VALUES
(9, 17, 0),
(10, 16, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tables`
--

CREATE TABLE `tables` (
  `idTable` int(11) NOT NULL,
  `nameTable` varchar(100) NOT NULL,
  `descriptionTable` varchar(255) NOT NULL,
  `passwordTable` varchar(255) DEFAULT NULL,
  `codeTable` varchar(6) NOT NULL,
  `idAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tables`
--

INSERT INTO `tables` (`idTable`, `nameTable`, `descriptionTable`, `passwordTable`, `codeTable`, `idAdmin`) VALUES
(16, 'Projetinho', 'Sala projeto', '123', 'hmac5x', 9),
(17, 'Pokemon', 'Pokemon', '123', 'hmac7z', 10);

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
(9, 'Thiago', 'th@gmail.com', '$2y$10$BHgRvtHiy7Lk8fW2aZS7DelZO0tCxwBry.7fxcIZwmwC0E3Fj5cm2'),
(10, 'Patrick', 'ptk@gmail.com', '$2y$10$a8ZEs5hu7OUK9xKwEGTE5uXWf433oyM27VwHiHr54KO0.ecirimI2');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `charactercard`
--
ALTER TABLE `charactercard`
  ADD PRIMARY KEY (`idCharacter`),
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
  ADD KEY `idUser` (`idAdmin`);

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
  MODIFY `idCharacter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `tables`
--
ALTER TABLE `tables`
  MODIFY `idTable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
