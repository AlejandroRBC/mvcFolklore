-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS folklore_boliviano;
USE folklore_boliviano;

-- Crear tabla BAILE con autoincrement
CREATE TABLE BAILE (
    id_baile INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ritmo VARCHAR(50)
);

-- Crear tabla DEPARTAMENTO con autoincrement
CREATE TABLE DEPARTAMENTO (
    id_departamento INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    region VARCHAR(50)
);

-- Crear tabla FRATERNIDAD con autoincrement
CREATE TABLE FRATERNIDAD (
    id_fraternidad INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_creacion DATE,
    id_baile INT,
    FOREIGN KEY (id_baile) REFERENCES BAILE(id_baile)
);

-- Crear tabla BAILARIN (sin autoincrement - es CI)
CREATE TABLE BAILARIN (
    ci_bailarin INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fec_nac DATE
);

-- Crear tabla ENTRADA con autoincrement
CREATE TABLE ENTRADA (
    id_entrada INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    gestion INT,
    fecha DATE
);

-- Crear tabla CRONOGRAMA (clave primaria compuesta)
CREATE TABLE CRONOGRAMA (
    id_fraternidad INT,
    id_entrada INT,
    hora TIME,
    PRIMARY KEY (id_fraternidad, id_entrada),
    FOREIGN KEY (id_fraternidad) REFERENCES FRATERNIDAD(id_fraternidad),
    FOREIGN KEY (id_entrada) REFERENCES ENTRADA(id_entrada)
);

-- Crear tabla PERTENECE (clave primaria compuesta)
CREATE TABLE PERTENECE (
    ci_bailarin INT,
    id_fraternidad INT,
    PRIMARY KEY (ci_bailarin, id_fraternidad),
    FOREIGN KEY (ci_bailarin) REFERENCES BAILARIN(ci_bailarin),
    FOREIGN KEY (id_fraternidad) REFERENCES FRATERNIDAD(id_fraternidad)
);

-- Crear tabla ES_DE (clave primaria compuesta)
CREATE TABLE ES_DE (
    id_baile INT,
    id_departamento INT,
    PRIMARY KEY (id_baile, id_departamento),
    FOREIGN KEY (id_baile) REFERENCES BAILE(id_baile),
    FOREIGN KEY (id_departamento) REFERENCES DEPARTAMENTO(id_departamento)
);