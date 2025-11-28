CREATE DATABASE empresa;
USE empresa;

CREATE TABLE departamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departamento VARCHAR(50)
);

CREATE TABLE skill (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);

CREATE TABLE empleado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    edad INT,
    fecha_alta DATE,
    activo BOOLEAN,
    id_departamento INT,
    id_responsable INT,
    FOREIGN KEY (id_departamento) REFERENCES departamento(id),
    FOREIGN KEY (id_responsable) REFERENCES empleado(id)
);

CREATE TABLE empleado_skill (
    id_empleado INT,
    id_skill INT,
    FOREIGN KEY (id_empleado) REFERENCES empleado(id),
    FOREIGN KEY (id_skill) REFERENCES skill(id)
);
