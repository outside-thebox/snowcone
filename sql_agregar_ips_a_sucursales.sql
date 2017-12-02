ALTER TABLE `sucursales`
	ADD COLUMN `ip` VARCHAR(20) NULL DEFAULT NULL AFTER `email`;

ALTER TABLE `sucursales`
	ADD COLUMN `conexion` VARCHAR(20) NULL DEFAULT NULL AFTER `ip`;
	
UPDATE `sucursales` SET `ip`='10.8.0.14',conexion='mysql_shell' WHERE  `id`=2;
UPDATE `sucursales` SET `ip`='10.8.0.11',conexion='mysql_cuartel5' WHERE  `id`=3;
UPDATE `sucursales` SET `ip`='10.8.0.12',conexion='mysql_croacia' WHERE  `id`=4;
UPDATE `sucursales` SET `ip`='10.8.0.13',conexion='mysql_gasparcampos' WHERE  `id`=5;


