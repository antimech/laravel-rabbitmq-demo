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
php artisan app:rabbitmq-publish '{"example": "message"}'
```

Consume:
```bash
php artisan app:rabbitmq-consume
```


## Supervisor

Create `laravel-rabbitmq-consume-worker.conf` file in `/etc/supervisor/conf.d` directory and paste it there:

```ini
[program:laravel-rabbitmq-consume-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/forge/service-b.com/artisan app:rabbitmq-consume
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=forge
numprocs=8
redirect_stderr=true
stdout_logfile=/home/forge/service-b.com/storage/log/worker.log
stopwaitsecs=3600
```

Update the config accordingly, specifically paths in `command` and `stdout_logfile`.


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
