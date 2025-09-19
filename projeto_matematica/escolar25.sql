-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01/09/2025 às 23:34
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `escolar25`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `created`, `modified`) VALUES
(1, 'Introdução à Programação', '2025-06-05 10:30:00', '2025-08-30 15:21:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos_disciplinas`
--

DROP TABLE IF EXISTS `cursos_disciplinas`;
CREATE TABLE IF NOT EXISTS `cursos_disciplinas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `id_disciplina` int NOT NULL,
  `ano` varchar(4) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_disciplina` (`id_disciplina`),
  KEY `id_curso` (`id_curso`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cursos_disciplinas`
--

INSERT INTO `cursos_disciplinas` (`id`, `id_curso`, `id_disciplina`, `ano`, `serie`, `created`, `modified`) VALUES
(1, 1, 1, '2025', '1', '2025-06-05 08:00:00', '2025-06-05 08:00:00'),
(2, 1, 2, '2025', '1', '2025-06-05 08:10:00', '2025-06-05 08:10:00'),
(3, 1, 3, '2025', '2', '2025-06-05 08:20:00', '2025-06-05 08:20:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinas`
--

DROP TABLE IF EXISTS `disciplinas`;
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `ementa` varchar(2048) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `disciplinas`
--

INSERT INTO `disciplinas` (`id`, `nome`, `ementa`, `created`, `modified`) VALUES
(1, 'Lógica de Programação', 'Introdução aos fundamentos da lógica computacional, algoritmos e estruturas de controle.', '2025-06-01 09:00:00', '2025-06-01 09:00:00'),
(2, 'Banco de Dados I', 'Conceitos básicos de banco de dados, modelagem relacional, SQL e normalização.', '2025-06-02 10:15:00', '2025-06-02 10:15:00'),
(3, 'Estruturas de Dados', 'Estudo de listas, pilhas, filas, árvores e algoritmos de ordenação e busca.', '2025-06-03 11:30:00', '2025-06-03 12:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
