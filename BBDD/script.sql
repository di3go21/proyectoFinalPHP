CREATE DATABASE IF NOT EXISTS tiendaGutiarras2;
USE tiendaGutiarras2;
/* */
create table USUARIO (
    id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(30) NOT NULL UNIQUE,
    password varchar(50) NOT NULL,
    nombre varchar(30) NOT NULL,
    apellidos varchar(30) NOT NULL,
    direccion varchar(150) NOT NULL,
    avatar varchar(150) NOT NULL,
    fechaRegistro varchar(10) NOT NULL

) ;
create table PRODUCTO (
    id int PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(30) NOT NULL UNIQUE,
    descripcion text(1000) NOT NULL,
    precio decimal(5,2) NOT NULL,
    unidadesDisponibles int NOT NULL,
    imagen varchar(40) NOT NULL
) ;
insert into PRODUCTO (nombre,descripcion,precio,unidadesDisponibles,imagen)  values 
    ("guitarra ibanez","guitarra acustica bonita",199.99,20,"guitarra_acustica_fender.jpg"),
    ("guitarra cort","guitarra electrica bonita",349.99,19,"guitarra_electrica_cort.jpg"),
    ("bajo cort","bajo acustico bonita",400.00,5,"bajo_acustico_cort.jpg"),
    ("bajo fender","bajo electrico bonita",220.00,10,"bajo_electrico_fender.jpg"),
    ("ukelele","ukelele acustico bonito",400.00,0,"ukelele.jpg");


create table CATEGORIA(
    id int PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(30) NOT NULL UNIQUE
);

insert into CATEGORIA (nombre) values ("Guitarras"),("Bajos"),("instrumentos acústico"),("instrumentos eléctricos"),("ukeleles");

create table PRODUCTO_CATEGORIA (
    xProducto int NOT NULL,
    xCategoria int not null,
    FOREIGN KEY (xProducto) REFERENCES PRODUCTO(id),
    FOREIGN KEY (xCategoria) REFERENCES CATEGORIA(id)
);
 insert into PRODUCTO_CATEGORIA (xProducto,xCategoria) values
    (1,1),
    (2,1),
    (3,2),
    (4,2),
    (1,3),
    (3,3),
    (2,4),
    (4,4),
    (5,5);

CREATE TABLE CARRITO_USUARIO (
    xUsuario int not null,
    xProducto int not null,
    cantidad int not null,
    PRIMARY KEY (xUsuario, xProducto),
    FOREIGN KEY (xUsuario) REFERENCES USUARIO(id),
    FOREIGN KEY (xProducto) REFERENCES PRODUCTO(id)
);


