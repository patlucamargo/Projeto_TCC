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

INSERT INTO `despesas` (`id`, `categoria`, `descricao`, `valor`, `dataVenc`, `pago`, `id_usuario`) VALUES
(11, 'Alimentação', 'pizza', 75, '2025-03-23', '1', 0),
(10, 'Alimentação', 'Refrigerante', 80, '2025-03-23', '1', 0),
(8, 'salario', 'pizza', 17, '2025-03-23', '1', 0),
(9, 'Alimentação', 'pizza', 54, '2025-03-23', '1', 0),
(12, 'Alimentação', 'Refrigerante', 15, '2025-03-24', '1', 0);


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


INSERT INTO `receitas` (`id`, `valor`, `categoria`, `data_registro`, `numParcelas`, `pago`, `id_usuario`) VALUES
(20, 550.00, 'Vale', '2024-12-10', 1, '1', 0),
(23, 1750.00, 'salario', '2025-03-07', 1, '1', 0);


DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(250) ,
  `email` varchar(50) DEFAULT NULL,
  `dat_nasc` date NOT NULL,
  `grupo_familiar` varchar(30) ,
  `login` varchar(30) NOT NULL,
  `senha` varchar(30) DEFAULT NULL,
  `nivel_acesso` varchar(10) DEFAULT 'usuario',
  PRIMARY KEY (`id`)
);

INSERT INTO `usuario` (`id`, `nome_completo`, `email`, `dat_nasc`, `grupo_familiar`, `login`, `senha`, `nivel_acesso`) VALUES
(1, 'Patricia L Camargo', 'plcamargo@gmail.com', '1982-04-24', 'CamargoNeves', 'plcamargo', '123456', 'admin'),
(2, 'Carlos Eduardo das Neves', 'boraoneves@hotmail.com', '1982-08-02', 'CamargoNeves', 'boris123', '123456', 'usuario'),
(3, 'thauane bezerra dantas dos santos', 'santosthauane030@gmail.com', '2005-12-13', 'bezerra', 'thauane.santos', 'th12345678', 'usuario'),
(4, 'Enzo Camargo', 'enzocamargo@gmail.com', '2011-01-24', 'CamargoNeves', 'plcamargo', '654321', 'usuario'),
(5, 'Enzo Bobs', 'enzo@gmail.com', '2011-01-24', 'CamargoNeves', 'enzocs', '12345', 'usuario'),
(6, 'Miriã de Jesus', 'miria@gmail.com', '2024-12-09', 'bezerra', 'miriaizidio', '12345', 'usuario'),
(7, 'Marina', 'marina123@gmail.com', '2024-12-09', 'amorim', 'amorimarina', '123456', 'usuario'),
(8, 'thauane bezerra dantas dos santos', 'thauanesantos736@gmail.com', '2005-12-13', 'bezerra', 'thauane.santos', '12345', 'usuario');
