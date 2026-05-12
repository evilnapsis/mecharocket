/*
* Base de datos Proyecto Mecharocket
* Actualizado 2026-04-18
* Author @evilnapsis
*/
create database mecharocket;
use mecharocket; 

create table user (
	id int not null auto_increment primary key,
	username varchar(50),
	name varchar(50),
	lastname varchar(50),
	email varchar(255),
	password varchar(60),
	is_active boolean not null default 1,
	type int not null default 1, /* 1. admin, 2. mechanic, 3. client*/
	created_at datetime
);

insert into user (email,password,type,created_at) value ("admin",sha1(md5("admin")),1,NOW());
/**
*/
create table contact (
	id int not null auto_increment primary key,
	name varchar(50),
	lastname varchar(50),
	email varchar(255),
	address varchar(255),
	phone varchar(255),
	image varchar(255),
	company varchar(255),
	phone2 varchar(255),
	cp varchar(255),
	city varchar(255),
	description text,
	type int default 1, /* 1. cliente, 2. proveedor*/
	is_active boolean not null default 1,
	created_at datetime not null
);

/* 
* Tablas adicionales para el sistema MechaRocket 
* Se mantienen las tablas 'user' y 'contact' existentes
*/
create table category (
	id int not null auto_increment primary key,
	name varchar(255),
	is_active boolean not null default 1
);
create table part (
	id int not null auto_increment primary key,
	name varchar(255),
	code varchar(255),
	description text,
	quantity int default 0,
	unit varchar(50) default 'Pieza',
	price_in float,
	price_out float,
	category_id int,
	is_active boolean not null default 1,
	created_at datetime,
	foreign key (category_id) references category(id)
);
create table vehicle (
	id int not null auto_increment primary key,
	plate varchar(50),
	vin varchar(50),
	brand varchar(50),
	model varchar(50),
	year int,
	color varchar(50),
	contact_id int,
	description text,
	created_at datetime,
	foreign key (contact_id) references contact(id)
);
create table service (
	id int not null auto_increment primary key,
	name varchar(255),
	description text,
	price float,
	is_active boolean not null default 1
);
create table status (
	id int not null auto_increment primary key,
	name varchar(50),
	color varchar(20)
);
/* Insertamos estados por defecto */
insert into status (name, color) values ('Recibido', '#6c757d'), ('En Diagnóstico', '#17a2b8'), ('En Reparación', '#007bff'), ('Esperando Refacciones', '#ffc107'), ('Terminado', '#28a745'), ('Entregado', '#6610f2');

create table job_category (
	id int not null auto_increment primary key,
	name varchar(255),
	is_active boolean not null default 1
);

insert into job_category (name) values ('Motor'), ('Transmisión'), ('Suspensión'), ('Frenos'), ('Sistema Eléctrico'), ('Carrocería y Pintura'), ('Aire Acondicionado'), ('Mantenimiento General');

create table space (
	id int not null auto_increment primary key,
	name varchar(255),
	description text,
	is_active boolean not null default 1
);

/* Insertamos algunos espacios por defecto */
insert into space (name) values ('Elevador 1'), ('Elevador 2'), ('Bahía A'), ('Bahía B'), ('Área de Pintura'), ('Patio de Espera');

create table operation (
	id int not null auto_increment primary key,
	description text,
	vehicle_id int,
	contact_id int,
	user_id int,
	mechanic_id int,
	status_id int,
	space_id int,
	start_date date,
	end_date date,
	total float default 0,
	created_at datetime,
	kind int default 1, /* 1. Repair, 3. Sale, 4. Purchase */
	foreign key (vehicle_id) references vehicle(id),
	foreign key (contact_id) references contact(id),
	foreign key (user_id) references user(id),
	foreign key (mechanic_id) references user(id),
	foreign key (status_id) references status(id),
	foreign key (space_id) references space(id)
);


create table configuration(
	id int not null auto_increment primary key,
	name varchar(255),
	short varchar(255),
	val text
);

insert into configuration (name,short,val) values 
("Nombre del Taller", "workshop_name", "Mecharocket"),
("Dirección", "workshop_address", "Av. Siempre Viva 123"),
("Teléfono", "workshop_phone", "555-1234"),
("Persona Responsable", "workshop_manager", "Isaac Newton"),
("Logo", "workshop_logo", "");

create table job (
	id int not null auto_increment primary key,
	operation_id int,
	job_category_id int,
	name varchar(255),
	description text,
	price float default 0,
	is_billable boolean not null default 0,
	status_id int,
	mechanic_id int,
	created_at datetime,
	foreign key (operation_id) references operation(id),
	foreign key (job_category_id) references job_category(id),
	foreign key (status_id) references status(id),
	foreign key (mechanic_id) references user(id)
);


create table operation_detail (
	id int not null auto_increment primary key,
	operation_id int,
	service_id int,
	part_id int,
	quantity int,
	price float,
	discount float default 0,
	foreign key (operation_id) references operation(id),
	foreign key (service_id) references service(id),
	foreign key (part_id) references part(id)
);
