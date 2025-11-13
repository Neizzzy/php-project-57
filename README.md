### Hexlet tests and linter status:
[![Actions Status](https://github.com/Neizzzy/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Neizzzy/php-project-57/actions)

[![PHP CI](https://github.com/Neizzzy/php-project-57/actions/workflows/phpci.yml/badge.svg)](https://github.com/Neizzzy/php-project-57/actions/workflows/phpci.yml)

____
# Менеджер задач

### Требования
* PHP ^8.3
* Node.js 24+ & npm
* Расширения: mbstring, curl, dom, xml, zip, pdo, pgsql
* Make

## Подготовка
Для Docker отредактируйте `.env.example`:

```txt
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=root
```
Выполните команду:
```
make setup
```

## Запуск
Выполните команду:
```
make start
```
