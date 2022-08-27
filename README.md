# Penca

- Fase de grupos - Octavos - Cuartos - Semis - Final
- Lenguaje: PHP
- Framework: Symfony 3
- Base de datos: MySQL

## Instrucciones:

### 1) Instalación de dependencias:

```
composer install
````
- :warning: Puede requerir uso de 'sudo'
- :warning: Se requiere tener instalado [Composer](https://getcomposer.org/)

### 2) Configuración de la base de datos:

Abrir el archivo app/config/parameters.yml y colocar en estos valores los datos correspondientes:
```
database_host: 127.0.0.1
database_port: xxx
database_name: xxx
database_user: xxx
database_password: xxx
```

### 3) Creación de base de datos:
```
php bin/console doctrine:schema:update --force
````
(Previo a este comando crear la base de datos)

### 4) Crear un usuario admin con los siguientes comandos:

```
php bin/console fos:user:create german
php bin/console fos:user:activate german
php bin/console fos:user:promote german ROLE_SUPER_ADMIN
```

### 5) Cambiar en base de datos:
En la tabla 'usuario', al user recién creado, agregarle 'admin' en el campo 'tipo'.

### 6) Acceder:
Ingresar desde: http://localhost/penca/web/penca.php :soccer:

## Licencia

MIT
