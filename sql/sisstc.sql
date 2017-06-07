# Host: stchost.com.br  (Version 5.5.54-0ubuntu0.14.04.1)
# Date: 2017-06-06 19:00:50
# Generator: MySQL-Front 6.0  (Build 1.98)


#
# Structure for table "tbcliente"
#

CREATE TABLE `tbcliente` (
  `cpf` bigint(20) NOT NULL DEFAULT '0',
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `datadenascimento` date DEFAULT NULL,
  `cep` varchar(255) DEFAULT NULL,
  `logradouro` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "tbcompra"
#

CREATE TABLE `tbcompra` (
  `Idcompra` int(11) NOT NULL AUTO_INCREMENT,
  `cpfcliente` bigint(20) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`Idcompra`),
  KEY `cpfcliente` (`cpfcliente`),
  CONSTRAINT `tbcompra_ibfk_1` FOREIGN KEY (`cpfcliente`) REFERENCES `tbcliente` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "tbpagamento"
#

CREATE TABLE `tbpagamento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `cpfcliente` bigint(20) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `cpfcliente` (`cpfcliente`),
  CONSTRAINT `tbpagamento_ibfk_1` FOREIGN KEY (`cpfcliente`) REFERENCES `tbcliente` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "tbproduto"
#

CREATE TABLE `tbproduto` (
  `Idproduto` int(11) NOT NULL AUTO_INCREMENT,
  `codigodebarras` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `custo` decimal(10,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `unidade` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Idproduto`),
  UNIQUE KEY `codigodebarras` (`codigodebarras`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;

#
# Structure for table "tbprodutosparacompra"
#

CREATE TABLE `tbprodutosparacompra` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompra` int(11) DEFAULT NULL,
  `idproduto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `idcompra` (`idcompra`),
  KEY `idproduto` (`idproduto`),
  CONSTRAINT `tbprodutosparacompra_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `tbcompra` (`Idcompra`),
  CONSTRAINT `tbprodutosparacompra_ibfk_2` FOREIGN KEY (`idproduto`) REFERENCES `tbproduto` (`Idproduto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
