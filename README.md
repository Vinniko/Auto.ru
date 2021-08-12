## Auto.ru (Symfony PHP framework test application)

## Installation

```bash
composer install
```

Copy .env from .env.example file and then write your database config

```bash
cp .env.example .env
```

Run migrations

```bash
php bin/console doctrine:migrations:migrate
```

Run seeders

```bash
php bin/console doctrine:fixtures:load
```

Run:

```bash
symfony serv
```
Enter in browser:

```bash 
localhost:8000
```




