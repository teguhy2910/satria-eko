# Docker Setup for Satria Eko Application

This application has been configured for Docker deployment. Below are the setup instructions.

## Prerequisites

1. **Docker Desktop** - Install from [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
2. **Git** (optional) - For cloning the repository

## Quick Start

### Option 1: Using docker-compose (Recommended)

1. Open terminal in the project directory
2. Run: `docker-compose up -d`
3. Access the application at: http://localhost:8080
4. Access phpMyAdmin at: http://localhost:8081

### Option 2: Build and run manually

1. Build the Docker image:
   ```bash
   docker build -t satria-eko:latest .
   ```

2. Run the container:
   ```bash
   docker run -p 8080:80 satria-eko:latest
   ```

3. Access the application at: http://localhost:8080

## Application Structure

The docker-compose setup includes:

1. **app** - Laravel PHP application (port 8080)
2. **db** - MySQL 5.7 database (port 3306)
3. **phpmyadmin** - Database management (port 8081)

## Environment Configuration

The `.env` file has been configured for Docker with:
- Database host: `db` (Docker service name)
- Database password: `secret`
- Application key: Generated automatically

## Database Setup

1. The database will be created automatically when the containers start
2. You may need to run migrations:
   ```bash
   docker-compose exec app php artisan migrate
   ```

## Useful Commands

- Start services: `docker-compose up -d`
- Stop services: `docker-compose down`
- View logs: `docker-compose logs -f`
- Run artisan commands: `docker-compose exec app php artisan [command]`
- Access container shell: `docker-compose exec app bash`

## Troubleshooting

1. **Port conflicts**: Change ports in `docker-compose.yml`
2. **Permission issues**: Ensure storage directory has proper permissions
3. **Database connection**: Wait for MySQL to fully start (30-60 seconds)

## Building for Production

For production deployment:

1. Update `.env` with production values
2. Set `APP_DEBUG=false` and `APP_ENV=production`
3. Build with: `docker build -t satria-eko:prod .`
4. Use a production web server configuration