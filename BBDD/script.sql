CREATE DATABASE IF NOT EXISTS tiendaGutiarras;
USE tiendaGutiarras;

create table USUARIO (
    id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(30) NOT NULL UNIQUE,
    password varchar(50) NOT NULL,
    nombre varchar(30) NOT NULL,
    apellidos varchar(30) NOT NULL,
    direccion varchar(150) NOT NULL,
    fechaRegistro varchar(10) NOT NULL

) ;