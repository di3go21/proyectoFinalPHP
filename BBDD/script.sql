CREATE DATABASE IF NOT EXISTS tiendaguitarras2;
USE tiendaguitarras2;
/* */
create table USUARIO (
    id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(30) NOT NULL UNIQUE,
    password varchar(50) NOT NULL,
    nombre varchar(30) NOT NULL,
    apellidos varchar(30) NOT NULL,
    direccion varchar(150) NOT NULL,
    fechaRegistro varchar(10) NOT NULL,
    esAdmin varchar(2) default 'NO',
    puedeRealizarInformes varchar(2) default "NO"

) ;


create table baja (
    id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(30) NOT NULL,
    nombre varchar(30) NOT NULL,
    apellidos varchar(30) NOT NULL,
    direccion varchar(150) NOT NULL,
    fechaRegistro varchar(10) NOT NULL,
    fechaBaja varchar(10) NOT NULL,
    hora varchar(8) NOT NULL
    

) ;

create table alta (
    id int PRIMARY KEY AUTO_INCREMENT,
    email varchar(30) NOT NULL ,
    nombre varchar(30) NOT NULL,
    apellidos varchar(30) NOT NULL,
    fechaRegistro varchar(10) NOT NULL,
    hora varchar(8) NOT NULL

) ;


insert into USUARIO (email,password,nombre,apellidos,direccion,fechaRegistro,esAdmin,puedeRealizarInformes) values 
    ("admin1@admin.es",md5("123456"),"Diego","Leiva","corona verde","1990/09/16","SI","SI"),
    ("admin2@admin.es",md5("123456"),"Daniel","Hernandez","corona verde","1990/09/16","SI","NO"),
    ("admin3@admin.es",md5("123456"),"Oscar","Collado","corona verde","1990/09/16","SI","NO"),
    ("user1@user.es",md5("123456"),"Christian","Briones","corona verde","1990/09/16","NO","NO"),
    ("user2@user.es",md5("123456"),"Pablo","Illescas","corona verde","1990/09/16","NO","NO"),
    ("user3@user.es",md5("123456"),"Daniel","Alvaro","corona verde","1990/09/16","NO","NO"),
    ("user4@user.es",md5("123456"),"Adrian","Compi","corona verde","1990/09/16","NO","NO"),
    ("user5@user.es",md5("123456"),"Maria","Pinar","corona verde","1990/09/16","NO","NO"),
    ("user6@user.es",md5("123456"),"Alvaro","Aparicio8","corona verde","1990/09/16","NO","NO");

create table PRODUCTO (
    id int PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(30) NOT NULL UNIQUE,
    descripcion text(1000) NOT NULL,
    precio decimal(7,2) NOT NULL,
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
    xCategoria int not null/*,
    FOREIGN KEY (xProducto) REFERENCES PRODUCTO(id),
    FOREIGN KEY (xCategoria) REFERENCES CATEGORIA(id)*/
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


CREATE TABLE VENTA (
    id VARCHAR(15)  PRIMARY KEY,
    email varchar(30) not null,
    precioTotal decimal(7,2) not null,
    direccionEnvio  varchar(150) NOT NULL,
    fecha varchar(10)
    /* ,
    FOREIGN KEY (xUsuario) REFERENCES USUARIO(id)*/
);

create TABLE VENTA_ARTICULO(
    xVenta  VARCHAR(15) not null,
    xProducto INT not null,
    cantidad int not null,
    precio decimal(7,2)/*,
    *
    FOREIGN KEY (xVenta) REFERENCES VENTA(id),
    FOREIGN KEY (xProducto) REFERENCES PRODUCTO(id)/
    */
);