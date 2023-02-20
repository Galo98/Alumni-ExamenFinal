create database alumni;

use alumni;

create table roles(
    id int auto_increment,
    nombre varchar (30),
    primary key (id)
);

insert into roles (nombre) values ('administrador'), ('profesor'), ('alumno');

create table usuarios(
    id int auto_increment,
    nombre varchar(30),
    apellido varchar(30),
    usuario varchar(30),
    rol int,
    contraseña varchar(30),
    email varchar(30),
    dni int(8),
    foreign key (rol) references roles(id),
    primary key (id,rol)
);

insert into usuarios (nombre,apellido,usuario,rol,contraseña,email,dni) values ('galo','olguin','asdf',1,'1234','galo@gmail.com',41259861);

create table materias(
    id int(2) auto_increment,
    nombre varchar (30),
    primary key (id)
);

create table notas(
    idUsuario int,
    idMateria int,
    notas float(1.2),
    foreign key (idUsuario) references usuarios(id),
    foreign key (idMateria) references materias(id),
    primary key (idUsuario,idMateria)
);

alter table roles change nombre nombreRol varchar(30);

alter table usuarios add estado bool;

alter table materias change nombre nombreMateria varchar(30);

alter table notas drop column notas;
alter table notas add column notaParcial1 float(1.2);
alter table notas add column notaParcial2 float(1.2);
alter table notas add column notaFinal float(1.2);

update usuarios set estado = '1' where id = 1;

# select * from usuarios;

# select usuarios.nombre, usuarios.apellido, materias.nombreMateria,notas.notaParcial1,notas.notaPArcial2,notas.notaFinal from ((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id);

# select usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.usuario, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, 
