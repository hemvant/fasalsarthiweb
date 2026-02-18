#!/bin/bash
set -e

echo "Pulling latest code..."
git pull origin main

echo "Building staging..."
docker compose build fasalsarthi_staging

echo "Starting staging..."
docker compose up -d fasalsarthi_staging

echo "Waiting for staging..."
sleep 5

echo "Running migrations..."
docker compose exec fasalsarthi_staging php artisan migrate --force

echo "Stopping live..."
docker stop fasalsarthi_live || true

echo "Renaming live to old_live..."
docker rename fasalsarthi_live fasalsarthi_old || true

echo "Renaming staging to live..."
docker rename fasalsarthi_staging fasalsarthi_live

echo "Reloading nginx..."
docker compose exec nginx nginx -s reload

echo "Removing old container..."
docker rm fasalsarthi_old || true

echo "Deployment complete!"
