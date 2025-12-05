### Hexlet tests and linter status:
[![Actions Status](https://github.com/Neizzzy/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Neizzzy/php-project-57/actions)

[![PHP CI](https://github.com/Neizzzy/php-project-57/actions/workflows/phpci.yml/badge.svg)](https://github.com/Neizzzy/php-project-57/actions/workflows/phpci.yml)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Neizzzy_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Neizzzy_php-project-57)

[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Neizzzy_php-project-57&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=Neizzzy_php-project-57)

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
____
https://neizzzy-task-manager.onrender.com/
