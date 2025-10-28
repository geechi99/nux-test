# How to build

```bash
cp src/.env.example src/.env
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate

## Troubleshooting

If you get a "Permission denied" error when Laravel tries to write logs or cache:

Linux

```bash
docker-compose exec app chmod -R 755 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chown www-data:www-data database/database.sqlite
docker-compose exec app chmod 644 database/database.sqlite

### Troubleshooting: 419 Page Expired

If you encounter a **419 Page Expired** error in Laravel, it is usually caused by **stale cached configuration or session data**. This can happen after cloning the project, changing environment variables, or updating service bindings.

To fix this, run the following commands inside the Docker container:

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear

