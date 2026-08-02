# 99 Bottles

Современная версия тестового проекта 2010 года на Laravel 13, PHP 8.3 и SQLite. Проект намеренно сохраняет исходное назначение, внешний вид, тексты, legacy URL и основные взаимодействия: три коллекции, поиск, AJAX-карточки и «песню» с падающими бутылками.

## Локальный запуск

Нужен Docker Desktop. Запустите приложение:

```shell
docker compose up --build
```

Сайт будет доступен по адресу <http://localhost:8000>. При первом запуске Compose установит зависимости, создаст SQLite-базу в именованном volume, применит миграции и один раз загрузит исходные данные.

Обычная остановка сохраняет базу и зависимости:

```shell
docker compose down
```

Команда `docker compose down -v` удаляет именованные volumes, включая локальную SQLite-базу, и не является штатной частью lifecycle.

## Проверка

В работающем окружении выполните:

```shell
docker compose exec app composer test
```

Health endpoint доступен по адресу <http://localhost:8000/up>.

## Owner-доступ

Изменять напитки и наполненные бутылки может только владелец. Страница входа намеренно отсутствует в меню и доступна по адресу <http://localhost:8000/login>.

Сгенерируйте password hash в работающем контейнере:

```shell
docker compose exec app php -r "echo password_hash('change-me', PASSWORD_DEFAULT), PHP_EOL;"
```

Поместите полученный hash в `OWNER_PASSWORD_HASH` локального `.env` и перезапустите приложение:

```shell
docker compose restart app
```

Не сохраняйте пароль или его production hash в Git.

## Production

Локальный Compose не является способом production deployment. Требования приложения к среде размещения, данным, lifecycle hooks, smoke-проверкам и rollback описаны в [DEPLOYMENT.md](DEPLOYMENT.md).

## Документация

- [Функциональный контракт](docs/functional-contract.md)

## История проекта

Исходная версия 2010 года на Zend Framework и её исторические материалы сохранены в отдельном [legacy-репозитории](https://github.com/boxfrommars/bankirtest). Этот репозиторий содержит только современную Laravel-версию.
