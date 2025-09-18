-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01/09/2025 às 23:33
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
-- Banco de dados: `projetow`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `assunto`
--

DROP TABLE IF EXISTS `assunto`;
CREATE TABLE IF NOT EXISTS `assunto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `diciplina` varchar(100) NOT NULL,
  `assunto` varchar(150) NOT NULL,
  `id_serie` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `escola`
--

DROP TABLE IF EXISTS `escola`;
CREATE TABLE IF NOT EXISTS `escola` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `id_moderador` int NOT NULL,
  `deleted` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `escola`
--

INSERT INTO `escola` (`id`, `nome`, `id_moderador`, `deleted`) VALUES
(1, 'ifsuldeminas - campus tco', 1, 0),
(2, 'escola bueno brandão', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `moderador`
--

DROP TABLE IF EXISTS `moderador`;
CREATE TABLE IF NOT EXISTS `moderador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `moderadorcol` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `id_perfil` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_turma` varchar(2) NOT NULL,
  `deleted` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome`, `email`, `id_perfil`, `id_turma`, `deleted`) VALUES
(1, 'rogerio', 'rogerio@gmail.com', '1', '1', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoas_questao`
--

DROP TABLE IF EXISTS `pessoas_questao`;
CREATE TABLE IF NOT EXISTS `pessoas_questao` (
  `id_pessoa` varchar(2) NOT NULL,
  `id_questao` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questao`
--

DROP TABLE IF EXISTS `questao`;
CREATE TABLE IF NOT EXISTS `questao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `origem` varchar(50) NOT NULL,
  `imagem` varchar(20) NOT NULL,
  `enunciado` varchar(256) NOT NULL,
  `status` varchar(50) NOT NULL,
  `resolucao` varchar(256) NOT NULL,
  `video` varchar(10) NOT NULL,
  `pdf` varchar(100) NOT NULL,
  `saiba_mais` varchar(100) NOT NULL,
  `alternativa` varchar(256) NOT NULL,
  `alternativa_correta` varchar(256) NOT NULL,
  `id_serie` varchar(2) NOT NULL,
  `id_q_nivel` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `questao_assunto`
--

DROP TABLE IF EXISTS `questao_assunto`;
CREATE TABLE IF NOT EXISTS `questao_assunto` (
  `id_questao` varchar(2) NOT NULL,
  `id_assunto` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `q_nivel`
--

DROP TABLE IF EXISTS `q_nivel`;
CREATE TABLE IF NOT EXISTS `q_nivel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `pont_acerto` varchar(50) NOT NULL,
  `pont_erro` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `resp_quest`
--

DROP TABLE IF EXISTS `resp_quest`;
CREATE TABLE IF NOT EXISTS `resp_quest` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_questao` varchar(2) NOT NULL,
  `id_pessoa` varchar(2) NOT NULL,
  `resposta` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `serie`
--

DROP TABLE IF EXISTS `serie`;
CREATE TABLE IF NOT EXISTS `serie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ensino` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `periodo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `serie`
--

INSERT INTO `serie` (`id`, `ensino`, `periodo`) VALUES
(5, 'Técnico em Informática', '1° ano'),
(6, 'Técnico em Informática', '1° ano'),
(7, 'aaa', 'aaa44'),
(8, 'palo', 'asd');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_user`
--

DROP TABLE IF EXISTS `tipo_user`;
CREATE TABLE IF NOT EXISTS `tipo_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma`
--

DROP TABLE IF EXISTS `turma`;
CREATE TABLE IF NOT EXISTS `turma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ano` int NOT NULL,
  `id_serie` int NOT NULL,
  `id_escola` int NOT NULL,
  `deleted` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `turma`
--

INSERT INTO `turma` (`id`, `ano`, `id_serie`, `id_escola`, `deleted`) VALUES
(1, 2009, 6, 1, 1),
(2, 2010, 1, 1, 1),
(3, 1909, 8, 1, 1),
(4, 2033, 5, 1, 1),
(5, 1909, 7, 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
