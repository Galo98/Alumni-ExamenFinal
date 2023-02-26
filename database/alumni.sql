create database alumni;

use alumni;

create table roles(
    id int auto_increment,
    nombre varchar (30),
    primary key (id)
);

insert into roles (nombre) values ('ADMINISTRADOR'), ('PROFESOR'), ('ALUMNO');

create table estados(
	id int auto_increment,
    nombreEstado varchar(30),
    primary key (id)
);

insert into estados (nombreEstado) values ('ACTIVO'), ('INACTIVO'), ('SUSPENDIDO');

create table carreras(
	id int auto_increment,
    nombreCarrera varchar(70),
	diasCursada varchar(70),
    turno varchar(30),
    primary key (id)
);

create table usuarios(
    id int auto_increment,
    nombre varchar(30),
    apellido varchar(30),
    rol int,
    contraseña varchar(30),
    email varchar(30),
    dni int(8),
    foreign key (rol) references roles(id),
    primary key (id,rol)
);

create table materias(
    id int(2) auto_increment,
    materia varchar (30),
    profesor int,
    carrera int,
    foreign key (carrera) references carreras(id),
    foreign key (profesor) references usuarios(id),
    primary key (id,carrera)
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

alter table usuarios add idEstado int;
alter table usuarios add foreign key (idEstado) references estados(id);

alter table notas drop column notas;
alter table notas add column notaParcial1 float(1.2);
alter table notas add column notaParcial2 float(1.2);
alter table notas add column notaFinal float(1.2);

insert into usuarios (nombre,apellido,rol,contraseña,email,dni,idEstado) values ('GALO','OLGUIN',1,'1234','galo@gmail.com',41259861,1),
('MATIAS','BALLONE',2,'1234','mati@gmail.com',40125351,2),
('EZEQUIEL','EDUARTES',3,'1234','nemo@gmail.com',41521354,3);

#  select usuarios.nombre, usuarios.apellido, materias.materia,notas.notaParcial1,notas.notaPArcial2,notas.notaFinal from ((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id);

#  select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id);
 
# select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id) where usuarios.id = 1;
 
# select materias.id, materias.materia, usuarios.nombre, usuarios.apellido, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id);
 
# select * from carreras;

# select * from materias;
 
# select * from usuarios;
 
 






















