-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11/11/2025 às 02:07
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
  `nome_escola` varchar(256) NOT NULL,
  `cod_inep` int NOT NULL,
  `cep` varchar(256) NOT NULL,
  `rua` varchar(256) NOT NULL,
  `numero` varchar(256) NOT NULL,
  `bairro` varchar(256) NOT NULL,
  `cidade` varchar(256) NOT NULL,
  `estado` varchar(256) NOT NULL,
  `telefone` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `etapa_ensino` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo_escola` varchar(256) NOT NULL,
  `status` int NOT NULL COMMENT '0 - Não confirmou email\r\n1 - Email Confirmado\r\n3 - Aprovado',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `escolas`
--

INSERT INTO `escolas` (`id`, `nome_escola`, `cod_inep`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `telefone`, `email`, `etapa_ensino`, `tipo_escola`, `status`, `created`, `modified`) VALUES
(1, 'IFSULDEMINAS - CAMPUS TRÊS CORAÇÕES', 31013511, '37417-158', 'Rua Coronel Edgard Cavalcante de Albuquerque', '61', 'Chácara das Rosas', 'Três Corações', 'MG', '(35) 3239-9494', 'gabinete.trescoracoes@ifsuldeminas.edu.br', 'E. Médio', 'pública', 0, '2025-11-11 01:18:52', NULL);

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
-- Estrutura para tabela `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int NOT NULL,
  `cargo` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `logs`
--

INSERT INTO `logs` (`id`, `cargo`) VALUES
(0, 'Aluno'),
(1, 'Apoiador'),
(2, 'Professor'),
(3, 'MODERADOR');

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
-- Estrutura para tabela `pessoas`
--

DROP TABLE IF EXISTS `pessoas`;
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `foto_perfil` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cpf` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nome_escola` varchar(256) NOT NULL,
  `nome_turma` varchar(256) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `nivel_de_acesso` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `nome`, `email`, `foto_perfil`, `cpf`, `nome_escola`, `nome_turma`, `senha`, `nivel_de_acesso`) VALUES
(7, '123a', 'rcpo30@hotmail.com', 'uploads/foto_6912976eef70b.jpg', '12074383673', '31013511', '1', '$2y$10$apAexIfv4H1S2KdQIDgoTOEoQhiVPbYF0Ek6kmCExc.OC9j/kAjhK', 1);

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
  `nome_turma` varchar(256) NOT NULL,
  `cod_inep` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome_turma`, `cod_inep`) VALUES
(1, '3° INFORMÁTICA', '31013511'),
(2, '3° ADMINISTRAÇÃO', '31013511'),
(3, '3° MECÂNICA', '31013511');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
