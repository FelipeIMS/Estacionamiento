create database estacionamiento;

use estacionamiento;

/*
Created: 17-02-2022
Modified: 17-02-2022
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table vehiculo

CREATE TABLE `vehiculo`
(
  `id_vehiculo` Int NOT NULL AUTO_INCREMENT,
  `patente` Varchar(10) NOT NULL,
  `tipo_vehiculo` Int,
  `marca_vehiculo` Int,
  `cliente` Int,
  PRIMARY KEY (`id_vehiculo`, `patente`)
)
;

CREATE INDEX `IX_Relationship1` ON `vehiculo` (`tipo_vehiculo`)
;

CREATE INDEX `IX_Relationship2` ON `vehiculo` (`marca_vehiculo`)
;

CREATE INDEX `IX_Relationship16` ON `vehiculo` (`cliente`)
;

ALTER TABLE `vehiculo` ADD UNIQUE `patente` (`patente`)
;

-- Table area

CREATE TABLE `area`
(
  `id_area` Int NOT NULL AUTO_INCREMENT,
  `nombre_area` Varchar(20) NOT NULL,
  PRIMARY KEY (`id_area`)
)
;

ALTER TABLE `area` ADD UNIQUE `nombre_area` (`nombre_area`)
;

-- Table tipo_vehiculo

CREATE TABLE `tipo_vehiculo`
(
  `id_tpv` Int NOT NULL AUTO_INCREMENT,
  `nombre_tpv` Varchar(50) NOT NULL,
  PRIMARY KEY (`id_tpv`)
)
;

ALTER TABLE `tipo_vehiculo` ADD UNIQUE `nombre_tpv` (`nombre_tpv`)
;

-- Table marca_vehiculo

CREATE TABLE `marca_vehiculo`
(
  `id_mv` Int NOT NULL AUTO_INCREMENT,
  `nombre_marca` Varchar(50) NOT NULL,
  PRIMARY KEY (`id_mv`)
)
;

ALTER TABLE `marca_vehiculo` ADD UNIQUE `nombre_marca` (`nombre_marca`)
;

-- Table cliente

CREATE TABLE `cliente`
(
  `id_cliente` Int NOT NULL AUTO_INCREMENT,
  `rut` Varchar(15),
  `nombre` Varchar(40) NOT NULL,
  `apellido` Varchar(40) NOT NULL,
  `descuento` Float,
  `area` Int,
  PRIMARY KEY (`id_cliente`)
)
;

CREATE INDEX `IX_Relationship3` ON `cliente` (`area`)
;

-- Table ficha

CREATE TABLE `ficha`
(
  `id_ficha` Int NOT NULL AUTO_INCREMENT,
  `inicio` Datetime,
  `termino` Datetime,
  `observacion` Varchar(100),
  `total` Int,
  `vehiculo` Int,
  `patente` Varchar(10),
  PRIMARY KEY (`id_ficha`)
)
;

CREATE INDEX `IX_Relationship12` ON `ficha` (`vehiculo`, `patente`)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `vehiculo` ADD CONSTRAINT `vehiculo_tpv` FOREIGN KEY (`tipo_vehiculo`) REFERENCES `tipo_vehiculo` (`id_tpv`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `vehiculo` ADD CONSTRAINT `vehiculo_marca` FOREIGN KEY (`marca_vehiculo`) REFERENCES `marca_vehiculo` (`id_mv`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `cliente` ADD CONSTRAINT `cliente_area` FOREIGN KEY (`area`) REFERENCES `area` (`id_area`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `ficha` ADD CONSTRAINT `Relationship12` FOREIGN KEY (`vehiculo`, `patente`) REFERENCES `vehiculo` (`id_vehiculo`, `patente`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `vehiculo` ADD CONSTRAINT `vehiculo_cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE ficha add espacio_ocupado INTEGER;

select * from area;
select * from marca_vehiculo;
select * from tipo_vehiculo;
select * from cliente;
select * from vehiculo;
select * from ficha;

INSERT INTO area values (1, 'Urgencia');
INSERT INTO area values (2, 'Endoscopia');
INSERT INTO area values (3, 'Informatica');

INSERT INTO marca_vehiculo values (1, 'Chevrolet');
INSERT INTO marca_vehiculo values (2, 'Hyundai');

INSERT INTO tipo_vehiculo values(1, 'Familiar');
INSERT INTO tipo_vehiculo values(2, 'Automóvil pequeño');

INSERT INTO cliente values (1, '26.563.841-7', 'Felipe', 'Mendez', 0.10, 3);
INSERT INTO cliente values (2, '13.365.452-3', 'Luis', 'Yañez', 0.15, 3);


INSERT INTO vehiculo values(1, 'HB-CL-15', 1, 1, 2);
INSERT INTO vehiculo values(2, 'IU-CL-84', 2, 2, 1);
INSERT INTO vehiculo values(3, 'DF-TG-88', 1, 2, 1);

INSERT INTO ficha values(1, now(), now(), 'entrada vehiculo', 500, 1,'HB-CL-15',1);
INSERT INTO ficha values (2, now(), now(), 'entrada vehiculo', 1000, 2, 'IU-CL-84',1);
INSERT INTO ficha values (3, now(), now(), 'entrada vehiculo', 6200, 3, 'DF-TG-88',1);




 ALTER TABLE `cliente` CHANGE COLUMN `nombre` `nombre_cliente` varchar (100) NOT NULL;
 ALTER TABLE `cliente` CHANGE COLUMN `apellido` `apellido_cliente` varchar (100) NOT NULL;
 
 


select ficha.id_ficha as id, cliente.nombre_cliente, cliente.apellido_cliente, area.nombre_area, vehiculo.patente, inicio, termino, espacio_ocupado from ficha
inner join vehiculo on vehiculo.id_vehiculo = ficha.vehiculo
inner join cliente on cliente.id_cliente = vehiculo.cliente
inner join area on area.id_area = cliente.area;

select sum(espacio_ocupado) as contador from ficha  where termino is null;

-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 23 Tem 2019, 11:53:17
-- Sunucu sürümü: 8.0.16
-- PHP Sürümü: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `phpmultiuserlogin`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `login` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`) VALUES
(1, 'Admin', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 1),
(2, 'Simple User', 'user@user.com', '202cb962ac59075b964b07152d234b70', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;










