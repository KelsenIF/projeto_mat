-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 19/09/2025 às 15:26
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_mat`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anos_escolaridades`
--

DROP TABLE IF EXISTS `anos_escolaridades`;
CREATE TABLE IF NOT EXISTS `anos_escolaridades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_escolaridade` varchar(256) NOT NULL,
  `id_nivel_ensino` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `anos_escolaridades`
--

INSERT INTO `anos_escolaridades` (`id`, `nome_escolaridade`, `id_nivel_ensino`) VALUES
(1, '6º Ano do Ensino Fundamental', 1),
(2, '7º Ano do Ensino Fundamental', 1),
(3, '8º Ano do Ensino Fundamental', 1),
(4, '9º Ano do Ensino Fundamental', 1),
(5, '1º Ano do Ensino Médio', 2),
(6, '2º Ano do Ensino Médio', 2),
(7, '3º Ano do Ensino Médio', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `assuntos`
--

DROP TABLE IF EXISTS `assuntos`;
CREATE TABLE IF NOT EXISTS `assuntos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disciplina` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_escolaridade` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `assuntos`
--

INSERT INTO `assuntos` (`id`, `disciplina`, `id_escolaridade`) VALUES
(1, 'Geometria Analítica', 7),
(2, 'Mínimo Múltiplo Comum', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastros`
--

DROP TABLE IF EXISTS `cadastros`;
CREATE TABLE IF NOT EXISTS `cadastros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `user` int NOT NULL,
  `instituicao` varchar(256) NOT NULL,
  `turma` varchar(256) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `tipo_user` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cadastros`
--

INSERT INTO `cadastros` (`id`, `nome`, `user`, `instituicao`, `turma`, `senha`, `tipo_user`) VALUES
(1, 'kelsen', 123456789, '2', '2', '$2y$10$cQdUKXAsyY4rc6t/eYG.wePfJtLp9lKGwxOJCocHQ5V0EKsHtcxmG', 0),
(2, 'Gabriel Borges Silva Flores', 2147483647, '1', '7', '$2y$10$ZdV2w1aOAdRQDd0gvKxPgua.sAMVUyiJLZEqXidJnhd3Z9t6poYJe', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `escolas`
--

DROP TABLE IF EXISTS `escolas`;
CREATE TABLE IF NOT EXISTS `escolas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` int NOT NULL,
  `nome` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uf` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `municipio` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `escolas`
--

INSERT INTO `escolas` (`id`, `codigo`, `nome`, `uf`, `municipio`) VALUES
(1, 31013511, ' IFSULDEMINAS - CAMPUS TRÊS CORAÇÕES', 'MG', 'Três Corações');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagens`
--

DROP TABLE IF EXISTS `imagens`;
CREATE TABLE IF NOT EXISTS `imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_imagem` varchar(255) NOT NULL,
  `caminho_imagem` varchar(255) NOT NULL,
  `data_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `niveis_ensino`
--

DROP TABLE IF EXISTS `niveis_ensino`;
CREATE TABLE IF NOT EXISTS `niveis_ensino` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nivel_ensino` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `niveis_ensino`
--

INSERT INTO `niveis_ensino` (`id`, `nivel_ensino`) VALUES
(1, 'Ensino Fundamental'),
(2, 'Ensino Médio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

DROP TABLE IF EXISTS `questoes`;
CREATE TABLE IF NOT EXISTS `questoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `enunciado` text NOT NULL,
  `foto_questao` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `video_questao` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `material_questao` varchar(256) DEFAULT NULL,
  `alt_correta` varchar(256) NOT NULL,
  `alt_incorreta1` varchar(256) NOT NULL,
  `alt_incorreta2` varchar(256) NOT NULL,
  `alt_incorreta3` varchar(256) NOT NULL,
  `origem` varchar(256) NOT NULL,
  `id_nivel_ensino` int NOT NULL,
  `id_escolaridade` int NOT NULL,
  `id_assunto` int NOT NULL,
  `id_situacao` int NOT NULL COMMENT '0-> negada\r\n1-> aprovada\r\n2-> em analise',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `questoes`
--

INSERT INTO `questoes` (`id`, `enunciado`, `foto_questao`, `video_questao`, `material_questao`, `alt_correta`, `alt_incorreta1`, `alt_incorreta2`, `alt_incorreta3`, `origem`, `id_nivel_ensino`, `id_escolaridade`, `id_assunto`, `id_situacao`) VALUES
(9, 'tfhkj', '../../uploads/quest_img_68cd6da3ab5df_download.jpg', NULL, NULL, 'a', 'b', 'c', 'd', 'UFLA/2021', 2, 7, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
