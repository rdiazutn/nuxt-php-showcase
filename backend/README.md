
## Instalacion

```
$ git clone https://github.com/jpnavone/tax-motor
$ cd tax-motor/backend
```

Configuramos el env.example con las variables de entorno/aplicación y luego corremos:

```
$ cp .env.example .env
$ docker-compose up --build 
```

Luego instalaremos dependecias necesarias (se debe contar con composer & npm ):

```
$ composer install
$ php artisan key:generate
```
