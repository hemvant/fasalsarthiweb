#!/bin/bash

echo "Pulling latest code..."
git pull origin main

echo "Building fresh containers..."
docker compose build --no-cache

echo "Starting new containers..."
docker compose up -d --remove-orphans

echo "Running migrations..."
docker compose exec laravel_app php artisan migrate --force

echo "Optimizing Laravel..."
docker compose exec laravel_app php artisan config:cache
docker compose exec laravel_app php artisan route:cache
docker compose exec laravel_app php artisan view:cache

echo "Cleaning old images..."
docker image prune -f

echo "Deployment completed successfully!"