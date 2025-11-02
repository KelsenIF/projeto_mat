-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02/11/2025 às 21:38
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
-- Banco de dados: `projeto_mat`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos`
--

DROP TABLE IF EXISTS `acessos`;
CREATE TABLE IF NOT EXISTS `acessos` (
  `id` int NOT NULL,
  `nome` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `acessos`
--

INSERT INTO `acessos` (`id`, `nome`) VALUES
(0, 'Aluno'),
(1, 'Apoiador'),
(2, 'Professor');

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
-- Estrutura para tabela `cadastros`
--

DROP TABLE IF EXISTS `cadastros`;
CREATE TABLE IF NOT EXISTS `cadastros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `foto` varchar(256) NOT NULL,
  `user` varchar(256) NOT NULL,
  `instituicao` int NOT NULL,
  `turma` varchar(256) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `pergunta_seguranca` varchar(256) NOT NULL,
  `resposta_seguranca` varchar(256) NOT NULL,
  `tipo_user` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cadastros`
--

INSERT INTO `cadastros` (`id`, `nome`, `foto`, `user`, `instituicao`, `turma`, `senha`, `pergunta_seguranca`, `resposta_seguranca`, `tipo_user`) VALUES
(1, 'Kelsen Chaves', 'uploads/foto_68ddcbb4816190.80864973.png', '202311640005', 31013511, '1', '$2y$10$HXZDByLMdnES0UE9s2kHOem/WYoDwFmxLbT122K5v29rsoGa9xJBy', 'Qual o nome da rua onde você nasceu?', '$2y$10$/OcPIxDtIDmyTsIa9GxexulWe4ZyEPWOJnF5o0OSmjggsVJUJrkZC', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinas`
--

DROP TABLE IF EXISTS `disciplinas`;
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disciplina` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_escolaridade` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `disciplinas`
--

INSERT INTO `disciplinas` (`id`, `disciplina`, `id_escolaridade`) VALUES
(1, 'Geometria Analítica', 7),
(2, 'Mínimo Múltiplo Comum', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `escolas`
--

DROP TABLE IF EXISTS `escolas`;
CREATE TABLE IF NOT EXISTS `escolas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Código` int NOT NULL,
  `Nome` varchar(256) NOT NULL,
  `UF` varchar(256) NOT NULL,
  `Município` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `escolas`
--

INSERT INTO `escolas` (`id`, `Código`, `Nome`, `UF`, `Município`) VALUES
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
  `id_disciplina` int NOT NULL,
  `id_situacao` int NOT NULL COMMENT '0-> negada\r\n1-> aprovada\r\n2-> em analise',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

DROP TABLE IF EXISTS `turmas`;
CREATE TABLE IF NOT EXISTS `turmas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `codigoescola` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome`, `codigoescola`) VALUES
(1, '3°INFORMÁTICA', 31013511),
(2, '3°ADMINISTRAÇÃO', 31013511),
(3, '3°MECÂNICA', 31013511);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
