DROP TABLE IF EXISTS departamentos CASCADE;

CREATE TABLE departamentos (
    id           BIGSERIAL    PRIMARY KEY,
    codigo       VARCHAR(2)   NOT NULL UNIQUE,
    denominacion VARCHAR(255) NOT NULL,
    localidad    VARCHAR(255),
    fecha_alta   TIMESTAMP(0) NOT NULL DEFAULT LOCALTIMESTAMP
);

DROP TABLE IF EXISTS empleados CASCADE;

CREATE TABLE empleados (
    id              BIGSERIAL    PRIMARY KEY,
    numero          VARCHAR(4)   NOT NULL UNIQUE,
    nombre          VARCHAR(255) NOT NULL,
    apellidos       VARCHAR(255) NOT NULL,
    departamento_id BIGINT       REFERENCES departamentos (id)
);

-----------

INSERT INTO departamentos (codigo, denominacion, localidad)
VALUES ('10', 'Informática', 'Sanlúcar'),
       ('20', 'Administrativo', NULL),
       ('30', 'Matemáticas', 'Chipiona');

INSERT INTO empleados (numero, nombre, apellidos, departamento_id)
VALUES ('1000', 'Manolo', 'Pérez', 1),
       ('2000', 'María', 'Rodríguez', 3),
       ('3000', 'Rosa', 'González', NULL);
