# Laravel RabbitMQ Demo

This is a microservice demo of RabbitMQ paired with Laravel 10 project. Works on PHP `^8.1`


## Installation

```bash
cd service-a/
composer install
cd ..
```

```bash
cd service-b
composer install
```

```bash
docker run -it --rm --name rabbitmq -p 5672:5672 -p 15672:15672 rabbitmq:3.12-management
```

## Usage

Publish:
```bash
php artisan app:rabbitmq-publish
```

Consume:
```bash
php artisan app:rabbitmq-consume
```

## Testing

```bash
cd service-a/
php artisan test
cd ..
```

```bash
cd service-b/
php artisan test
```
