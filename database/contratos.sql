-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           10.2.3-MariaDB-log - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para contratos
CREATE DATABASE IF NOT EXISTS `contratos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `contratos`;

-- Copiando estrutura para tabela contratos.cidades
CREATE TABLE IF NOT EXISTS `cidades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `estados_id` int(11) NOT NULL,
  `ibge` int(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cidades_estados1_idx` (`estados_id`),
  CONSTRAINT `fk_cidades_estados1` FOREIGN KEY (`estados_id`) REFERENCES `estados` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5610 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.contratos
CREATE TABLE IF NOT EXISTS `contratos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `entrada` decimal(10,2) NOT NULL,
  `parcelas` int(11) NOT NULL,
  `vencimento` decimal(2,0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Aberto/1 - Fechado',
  `clientes_id` int(10) unsigned NOT NULL,
  `lotes_id` int(10) unsigned NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contratos_clientes1_idx` (`clientes_id`),
  KEY `fk_contratos_lotes1_idx` (`lotes_id`),
  KEY `fk_contratos_usuarios1_idx` (`usuarios_id`),
  CONSTRAINT `fk_contratos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `pessoas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_contratos_lotes1` FOREIGN KEY (`lotes_id`) REFERENCES `lotes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_contratos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.endereco
CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(150) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cep` decimal(8,0) NOT NULL,
  `clientes_id` int(10) unsigned NOT NULL,
  `cidades_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_endereco_clientes_idx` (`clientes_id`),
  KEY `fk_endereco_cidades1_idx` (`cidades_id`),
  CONSTRAINT `fk_endereco_cidades1` FOREIGN KEY (`cidades_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_endereco_clientes` FOREIGN KEY (`clientes_id`) REFERENCES `pessoas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.estados
CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL,
  `nome` varchar(75) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `ibge` int(2) NOT NULL,
  `sl` int(3) DEFAULT NULL,
  `ddd` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.lotes
CREATE TABLE IF NOT EXISTS `lotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `comprimento` decimal(10,2) NOT NULL,
  `largura` decimal(10,2) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `situacao` enum('vendido','aberto') NOT NULL DEFAULT 'aberto',
  `quadras_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lotes_quadras1_idx` (`quadras_id`),
  CONSTRAINT `fk_lotes_quadras1` FOREIGN KEY (`quadras_id`) REFERENCES `quadras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.parcelas
CREATE TABLE IF NOT EXISTS `parcelas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Aberto\\1 - Quitada',
  `recebido` decimal(10,2) DEFAULT NULL,
  `vencimento` date NOT NULL,
  `quitada` date DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `contratos_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_parcelas_contratos1_idx` (`contratos_id`),
  CONSTRAINT `fk_parcelas_contratos1` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.pessoas
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` decimal(11,0) NOT NULL,
  `rg` decimal(15,0) NOT NULL,
  `rg_emissao` date NOT NULL,
  `rg_org_expedidor` varchar(100) NOT NULL,
  `estado_civil` enum('solteiro','casado','divorciado','viuvo','separado') NOT NULL DEFAULT 'solteiro',
  `tipo` enum('cliente','vendedor') NOT NULL DEFAULT 'cliente',
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.quadras
CREATE TABLE IF NOT EXISTS `quadras` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.telefones
CREATE TABLE IF NOT EXISTS `telefones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numero` decimal(9,0) NOT NULL,
  `ddd` decimal(2,0) NOT NULL,
  `operadora` varchar(45) NOT NULL,
  `tipo` enum('celular','fixo','trabalho') NOT NULL DEFAULT 'celular',
  `clientes_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_telefones_clientes1_idx` (`clientes_id`),
  CONSTRAINT `fk_telefones_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `pessoas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela contratos.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status` enum('ativo','desativado') NOT NULL DEFAULT 'ativo',
  `criado_em` date NOT NULL DEFAULT current_timestamp(),
  `ultimo_acesso` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
