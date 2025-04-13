#!/bin/bash

# Stop and remove existing containers
docker compose down

# Build and start containers
docker compose up -d --build

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! docker compose exec mysql mysqladmin ping -h localhost -u app -p'!ChangeMe!' --silent; do
    sleep 1
done

# Run database migrations
docker compose exec api php bin/console doctrine:migrations:migrate --no-interaction

# Clear cache
docker compose exec api php bin/console cache:clear --env=prod

# Set proper permissions
chmod -R 755 .
chown -R www-data:www-data .

echo "Deployment completed!" 