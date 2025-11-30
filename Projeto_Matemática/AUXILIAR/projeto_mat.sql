-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 30/11/2025 às 22:35
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
-- Estrutura para tabela `disciplinas`
--

DROP TABLE IF EXISTS `disciplinas`;
CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disciplina` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_escolaridade` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `disciplinas`
--

INSERT INTO `disciplinas` (`id`, `disciplina`, `id_escolaridade`) VALUES
(2, 'Mínimo Múltiplo Comum', 4),
(33, 'TEORIA DOS CONJUNTOS', 5),
(10, 'NÚMEROS INTEIROS', 2),
(11, 'NÚMEROS RACIONAIS', 2),
(12, 'LINGUAGEM ALGÉBRICA', 2),
(13, 'GEOMETRIA', 2),
(14, 'GRANDEZAS E MEDIDAS', 2),
(15, 'PROPORCIONALIDADE', 2),
(16, 'EQUAÇÕES DO 1º GRAU', 2),
(17, 'NOÇÕES DE PROBABILIDADE E ESTATÍSTICA', 2),
(25, 'FUNÇÕES', 4),
(19, 'POTENCIAÇÃO E RADICIAÇÃO', 3),
(20, 'ÁLGEBRA: PRODUTOS NOTÁVEIS E FATORAÇÃO', 3),
(21, 'EQUAÇÕES E SISTEMAS', 3),
(22, 'GEOMETRIA PLANA E ESPACIAL', 3),
(23, 'GRANDEZAS E FUNÇÕES', 3),
(24, 'PROBABILIDADE E ESTATÍSTICA', 3),
(27, 'GEOMETRIA ANALÍTICA', 4),
(28, 'GEOMETRIA PLANA AVANÇADA', 4),
(29, 'MATEMÁTICA FINANCEIRA', 4),
(30, 'GEOMETRIA ESPACIAL', 4),
(31, 'ÁLGEBRA AVANÇADA', 4),
(32, 'PROBABILIDADE E ESTATÍSTICA', 4),
(34, 'RELAÇÕES E FUNÇÕES', 5),
(35, 'FUNÇÃO AFIM', 5),
(36, 'FUNÇÃO QUADRÁTICA', 5),
(37, 'FUNÇÃO MODULAR', 5),
(38, 'FUNÇÃO EXPONENCIAL', 5),
(39, 'FUNÇÃO LOGARÍTMICA', 5),
(40, 'SEQUÊNCIAS NUMÉRICAS', 6),
(41, 'MATRIZES', 6),
(42, 'SISTEMAS LINEARES', 6),
(43, 'ANÁLISE COMBINATÓRIA', 6),
(44, 'PROBABILIDADE', 6),
(45, 'TRIGONOMETRIA', 6),
(46, 'ESTATÍSTICA', 7),
(56, 'GEOMETRIA ANALÍTICA', 7),
(55, 'GEOMETRIA ESPACIAL MÉTRICA', 7),
(54, 'GEOMETRIA ESPACIAL POSICIONAL', 7),
(53, 'GEOMETRIA PLANA', 7),
(57, 'NÚMEROS COMPLEXOS', 7),
(58, 'POLINÔMIOS', 7),
(60, 'NÚMEROS NATURAIS', 1),
(61, 'MÚLTIPLOS E DIVISORES', 1),
(62, 'NÚMEROS FRACIONÁRIOS', 1),
(63, 'NÚMEROS DECIMAIS', 1),
(64, 'RAZÕES E PORCENTAGENS', 1),
(65, 'INTRODUÇÃO À ÁLGEBRA', 1),
(66, 'GEOMETRIA', 1);

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
  `nivel_de_acesso` int NOT NULL COMMENT '1 - aluno; 2- ajudante; 3 - Professor; 4 - Moderador',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `nome`, `email`, `foto_perfil`, `cpf`, `nome_escola`, `nome_turma`, `senha`, `nivel_de_acesso`) VALUES
(9, 'Kelsen Chaves Paiva de Oliveira Gonçalves Antônio', 'kelsenchaves27@gmail.com', 'uploads/foto_6925ddf10a212.png', '12074383673', '31013511', '1', '$2y$10$JeYmyHltbQ3ZSVR44ZmKceoeg29RghY0Pxn50Fhzui3EdQ9Y3v4HC', 4),
(14, 'Gabriel B S Flores', 'gabriel.borges@alunos.ifsuldeminas.edu.br', 'uploads/foto_692cc654bb3c7.jpg', '11301537624', '31013511', '1', '$2y$10$9CrFtNCxnXYiirdlWFZa4uG2djGmj.AeeOf6XufByjStmFmhRQBBe', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

DROP TABLE IF EXISTS `questoes`;
CREATE TABLE IF NOT EXISTS `questoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `enunciado` text NOT NULL,
  `video_aula_link` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `questoes`
--

INSERT INTO `questoes` (`id`, `enunciado`, `video_aula_link`, `foto_questao`, `video_questao`, `material_questao`, `alt_correta`, `alt_incorreta1`, `alt_incorreta2`, `alt_incorreta3`, `origem`, `id_nivel_ensino`, `id_escolaridade`, `id_disciplina`, `id_situacao`) VALUES
(7, 'Determine o MMC entre 12 e 18:', NULL, '', NULL, '', '36', '48', '42', '24', 'Banco de dados', 1, 1, 60, 1),
(6, 'Qual é o resultado de 7² - 4³ + 10?', NULL, '', NULL, '', '-5', '15 ', '3', '-3', 'Banco de dados', 1, 1, 60, 1),
(5, 'Calcule o valor da expressão: 12 + 8 ÷ 4 × 2 - 5', NULL, '', NULL, NULL, '11', '13', '12', '14', 'Banco de dados', 1, 1, 60, 1),
(8, 'Encontre o MDC entre 24 e 36:', NULL, '', NULL, '', '12', ' 8', '6', '18', 'Banco de dados', 1, 1, 60, 1),
(9, 'Simplifique a expressão: (15 - 3) × 2 + 8 ÷ 4', NULL, '', NULL, '', '26', '24 ', '25 ', '27 ', 'Banco de dados', 1, 1, 60, 1),
(10, 'Resolva: [20 - (8 - 3) × 2] ÷ 5 + 7', NULL, '', NULL, '', '9', '7 ', '8', '10', 'Banco de dados', 1, 1, 60, 1),
(11, 'Qual número deve substituir X na equação: 3² + X = 5 × 4 - 1', NULL, '', NULL, '', '10', '11 ', '12 ', '9 ', 'Banco de dados', 1, 1, 60, 1),
(12, 'Decomponha 180 em fatores primos e determine quantos divisores ele possui:', NULL, '', NULL, NULL, '18 divisores', '12 divisores', '24 divisores', '20 divisores ', 'Banco de dados', 1, 1, 60, 1),
(13, 'Três ônibus passam por um terminal a cada 15, 20 e 30 minutos. Se passaram juntos às 8h, que horas passarão juntos novamente?', NULL, '', NULL, NULL, '9h', '8h30min ', '9h30min ', '10h ', 'Banco de dados', 1, 1, 60, 1),
(14, 'Um terreno retangular mede 48m × 60m. Qual o maior tamanho possível para ladrilhos quadrados que cobrirão exatamente o piso?', NULL, '', NULL, '', '12m × 12m', '8m × 8m', '10m × 10m', '15m × 15m ', 'Banco de dados', 1, 1, 60, 1),
(15, 'Resolva: {18 ÷ [2 + (6 - 1) × 2]} × 3 - 5', NULL, '', NULL, NULL, ' -0,5', '-1,5', '0,5', '1,5 ', 'Banco de dados', 1, 1, 60, 1),
(16, 'Um número é divisível por 6 e por 8. Qual o menor valor possível para esse número se ele está entre 50 e 100?', NULL, '', NULL, NULL, '72', '64', ' 80', '96', 'Banco de dados', 1, 1, 60, 1),
(17, 'Determine o valor de: 2³ + 3² - 4¹ + 5⁰', NULL, '', NULL, NULL, '14', '15 ', '13 ', '16 ', 'Banco de dados', 1, 1, 60, 1),
(18, 'Qual é a soma dos divisores naturais de 36?', NULL, '', NULL, NULL, '91', '78 ', '89 ', '95 ', 'Banco de dados', 1, 1, 60, 1),
(19, 'Um número tem 12 divisores. Se sua decomposição em fatores primos é 2ᵃ × 3ᵇ, qual das seguintes NÃO é uma possibilidade para (a, b)?', NULL, '', NULL, NULL, ' (4, 4)', ' (2, 3)', '(5, 1) ', '(1, 5) ', 'Banco de dados', 1, 1, 60, 1),
(20, '\\sqrt{3}', NULL, '', NULL, NULL, '\'12', 'b', 'b', 'banana', 'dsgdg', 1, 2, 12, 2),
(22, 'Qual o resultado de \\begin{cases} x + y = 2 \\\\ 2x - y = 3 \\end{cases}', NULL, '', NULL, '', 'tIM mAIA', 'PERICLES', 'BANANA', 'CHICKEN JOCKEY', 'UFLA2021', 2, 7, 54, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
