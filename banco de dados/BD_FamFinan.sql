drop database famfinan;

create database famfinan;
use famfinan;
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `despesas`;
CREATE TABLE IF NOT EXISTS `despesas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `dataVenc` date DEFAULT NULL,
  `pago` varchar(10) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id`)
) ;


DROP TABLE IF EXISTS `gruposfamiliar`;
CREATE TABLE IF NOT EXISTS `gruposfamiliar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `administrador` varchar(100) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `integrantes` int DEFAULT NULL,
  `percentual` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `administrador` (`administrador`)
);

DROP TABLE IF EXISTS `receitas`;
CREATE TABLE IF NOT EXISTS `receitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) DEFAULT NULL,
  `categoria` varchar(30) DEFAULT NULL,
  `data_registro` varchar(50) DEFAULT NULL,
  `numParcelas` int NOT NULL,
  `pago` varchar(10) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(250) ,
  `email` varchar(50) DEFAULT NULL,
  `grupo_familiar` varchar(30) ,
  `login` varchar(30) NOT NULL,
  `senha` varchar(30) DEFAULT NULL,
  `nivel_acesso` varchar(10) DEFAULT 'usuarios',
  PRIMARY KEY (`id`)
);


