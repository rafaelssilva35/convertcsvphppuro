CREATE DATABASE banco;

CREATE TABLE `banco`.`dados` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `razao_social` VARCHAR(100) NULL,
  `endereco` VARCHAR(100) NULL,
  `bairro` VARCHAR(50) NULL,
  `cep` VARCHAR(8) NULL,
  `municipio` VARCHAR(30) NULL,
  `uf` VARCHAR(2) NULL,
  `telefone` INT(11) NULL,
  `cnpj` INT(14) NULL,
  `valor` DOUBLE(13,2) NULL,
  `vencimento` DATE NULL,
  PRIMARY KEY (`id`));
