# La Penca! :soccer:

Penca de fútbol
Fase de grupos - Octavos - Cuartos - Semis - Final
Lenguaje: PHP
Framework: Symfony 3
Base de datos: MySQL

## Instrucciones:

### 1) Instalación de dependencias:

```
composer install
````
(Puede requerir uso de 'sudo')

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
php app/console doctrine:schema:update --force
````

### 4) Crear un usuario admin con los siguientes comandos:

```
php app/console fos:user:create german
php app/console fos:user:activate german
php app/console fos:user:promote german ROLE_SUPER_ADMIN
```

## Licencia

MIT
