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
	notaParcial1 float(1.2),
    notaParcial2 float(1.2),
    notaFinal float(1.2),
    foreign key (idUsuario) references usuarios(id),
    foreign key (idMateria) references materias(id),
    primary key (idUsuario,idMateria)
);

alter table roles change nombre nombreRol varchar(30);

alter table usuarios add idEstado int;
alter table usuarios add foreign key (idEstado) references estados(id);

insert into usuarios (nombre,apellido,rol,contraseña,email,dni,idEstado) values 
('ADMIN','ADMIN',1,'1234','ADMIN@GMAIL.COM',1234,1),
('PAULA','GIAIMO',2,'1234','PAULA@GMAIL.COM',40000001,1),
('GRACIANA','ROLDAN',2,'1234','GRACIANA@GMAIL.COM',40000002,1),
('JUAN','PELLEGRINI',2,'1234','PELLEGRINI@GMAIL.COM',40000003,1),
('GALO','OLGUIN',3,'1234','GALO@GMAIL.COM',40000004,1),
('MATIAS','KARLEN',3,'1234','MATIAS@GMAIL.COM',40000005,1),
('LUCIANO','HERDELI',3,'1234','LUCIANO@GMAIL.COM',40000006,2),
('JUAN','LOPEZ',3,'1234','JUAN@GMAIL.COM',40000007,3),
('MARIANO','MORBELI',3,'1234','MARIANO@GMAIL.COM',40000008,3),
('CELESTE','DIAZ',3,'1234','CELESTE@GMAIL.COM',40000009,2),
('DANA','MORE',3,'1234','DANA@GMAIL.COM',40000010,2),
('ANGELICA','ZOZULA',2,'1234','ZOZULA@GMAIL.COM',40000011,1),
('MIGUEL','MARTINEZ',2,'1234','MIGUEL@GMAIL.COM',40000012,1),
('GABRIELA','PUGLIESE',2,'1234','GABRIELA@GMAIL.COM',40000013,1),
('RAMIRO','VILLAR',2,'1234','RAMIRO@GMAIL.COM',40000014,1),
('CINTIA','CASTRO',2,'1234','CINTIA@GMAIL.COM',40000015,1),
('VERÓNICA','CORREA',2,'1234','VERONICA@GMAIL.COM',40000016,1),
('FABIAN','PERINO',2,'1234','RAMIRO@GMAIL.COM',40000017,1);

insert into carreras (nombreCarrera,diasCursada,turno) values 
('ANALISTA DE SISTEMAS','LUNES,MARTES,MIERCOLES,JUEVES,VIERNES','VESPERTINO'),
('PROFESORADO DE MATEMÁTICA','LUNES,MARTES,MIERCOLES,JUEVES,VIERNES','VESPERTINO'),
('PROFESORADO DE INGLÉS','LUNES,MARTES,MIERCOLES,JUEVES,VIERNES','VESPERTINO');

insert into materias (materia,profesor,carrera) values 
('ALGORITMOS Y ESTRUCTURA DE DATOS 2',2,1),
('BASE DE DATOS 2',4,1),
('PRACTICAS PROFESIONALES 2',3,1),
('INGLES 2',12,1),
('GEOMETRÍA',14,2),
('ÁLGEBRA',13,2),
('INTRODUCCIÓN AL CALCULO',15,2),
('LENGUA Y CULTURA',16,3),
('LENGUA Y EXPRESIÓN ESCRITA 1',17,3),
('LENGUA Y EXPRESIÓN ORAL 1',18,3);


# select id,materia from materias where carrera = 1;

# select count(id) from materias where carrera = 1;

# select * from notas;

# select notas.idUsuario, notas.idMateria, usuarios.nombre, usuarios.apellido, materias.materia, carreras.nombreCarrera ,notas.notaParcial1,notas.notaParcial2,notas.notaFinal from (((usuarios inner join notas on usuarios.id = notas.idUsuario) inner join materias on notas.idMateria = materias.id) inner join carreras on carreras.id = materias.carrera );

#  select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id);
 
# select usuarios.id, usuarios.nombre, usuarios.apellido, roles.nombreRol, usuarios.contraseña, usuarios.email, usuarios.dni, estados.nombreEstado from (( usuarios inner join roles on usuarios.rol = roles.id) inner join estados on usuarios.idEstado = estados.id) where usuarios.id = 1;
 
# select materias.id, materias.materia, materias.profesor, materias.carrera, usuarios.nombre, usuarios.apellido, usuarios.dni, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id);

# select notas.idMateria, notas.idUsuario, notas.notaParcial1, notas.notaParcial2, notas.notaFinal, materias.id, materias.profesor from notas inner join materias on notas.idMateria = materias.id where materias.profesor = 2;
 
# select * from carreras;

# select * from materias;
 
# select * from usuarios;

# select materias.id, materias.materia, usuarios.nombre, usuarios.apellido, carreras.nombreCarrera from (( materias inner join usuarios on materias.profesor = usuarios.id ) inner join carreras on materias.carrera = carreras.id) where materias.id = 1;


 
 






















