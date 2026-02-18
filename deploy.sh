#!/bin/bash

echo "Pulling latest code..."
git pull origin main

echo "Building staging..."
docker compose build fasalsarthi_staging

echo "Starting staging..."
docker compose up -d fasalsarthi_staging

echo "Running migrations..."
docker compose exec fasalsarthi_staging php artisan migrate --force

echo "Switching traffic to staging..."

sed -i 's/fasalsarthi_live:9000/fasalsarthi_staging:9000/' nginx/default.conf
docker compose exec nginx nginx -s reload

echo "Stopping old live..."
docker stop fasalsarthi_live

echo "Renaming staging to live..."

docker rename fasalsarthi_staging fasalsarthi_live

echo "Deployment complete!"
