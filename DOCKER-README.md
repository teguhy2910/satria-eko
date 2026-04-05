# Docker Deployment Guide for Satria Eko

This guide covers Docker deployment for the Satria Eko Laravel application.

## Quick Start

### Development Environment
```bash
# Clone and setup
git clone <repository>
cd satria-eko

# Copy environment file
cp .env.example .env

# Start development environment
make up

# Install dependencies
make composer CMD="install"

# Generate application key
make artisan CMD="key:generate"

# Run migrations
make artisan CMD="migrate"

# Access the application
open http://localhost:8080
```

### Production Deployment
```bash
# Build production image
make build

# Start production stack
make up-prod
```

## Docker Configuration

### Production Dockerfile (`Dockerfile`)
- Multi-stage build for smaller image size
- PHP 8.1 with Apache
- Optimized PHP extensions for Laravel 10
- OPCache enabled for performance
- Non-root user for security
- Health checks for container monitoring

### Development Dockerfile (`Dockerfile.dev`)
- Includes Xdebug for debugging
- Development PHP configuration
- Node.js for frontend assets
- Mounts source code for live reload

## Environment Variables

Create a `.env` file with the following variables:

```env
# Application
APP_NAME="Satria Eko"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=satria_eko
DB_USERNAME=satria_user
DB_PASSWORD=secure_password

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## Docker Compose Files

### Development (`docker-compose.yml`)
- PHP application with mounted volumes
- MySQL 8.0 database
- PHPMyAdmin for database management
- Health checks

### Production (`docker-compose.prod.yml`)
- Production-ready stack
- Nginx reverse proxy
- SSL support (configure in `docker/nginx/ssl/`)
- Database with persistent volume
- Health checks and monitoring

## Performance Optimizations

### PHP Configuration
- OPCache enabled with 256MB memory
- Realpath cache for faster file lookups
- Optimized memory limits for Laravel
- File upload limits configured

### Apache Configuration
- Gzip compression enabled
- Static asset caching
- Security headers
- Optimized keep-alive settings

### Database Configuration
- MySQL 8.0 with native password authentication
- Optimized configuration in `docker/mysql/my.cnf`
- Persistent volume for data

## Security Best Practices

1. **Non-root user**: Application runs as non-root user
2. **File permissions**: Proper permissions set on storage and cache directories
3. **Environment variables**: Sensitive data stored in environment variables
4. **Health checks**: Container health monitoring
5. **Security headers**: XSS protection, frame options, content type options

## Monitoring and Maintenance

### Health Checks
Containers include health checks that can be monitored:
```bash
# Check container health
docker-compose ps

# View logs
make logs
```

### Backup Database
```bash
# Create backup
make db-backup

# Restore from backup
docker-compose exec db mysql -u root -p < backup_file.sql
```

### Update Application
```bash
# Pull latest changes
git pull

# Rebuild and restart
make build
make restart
```

## Troubleshooting

### Common Issues

1. **Permission denied errors**
   ```bash
   sudo chown -R $USER:$USER storage bootstrap/cache
   ```

2. **Database connection errors**
   ```bash
   # Check if database is running
   docker-compose ps db
   
   # Check database logs
   docker-compose logs db
   ```

3. **Application not starting**
   ```bash
   # Check application logs
   make logs
   
   # Rebuild containers
   make down
   make build
   make up
   ```

### Debug Mode
For development, enable debug mode in `.env`:
```env
APP_DEBUG=true
```

## Production Deployment Checklist

- [ ] Update all environment variables in `.env`
- [ ] Generate secure application key
- [ ] Configure SSL certificates in `docker/nginx/ssl/`
- [ ] Set up database backups
- [ ] Configure monitoring and alerts
- [ ] Test health checks
- [ ] Perform load testing
- [ ] Set up CI/CD pipeline

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com/)
- [PHP Docker Images](https://hub.docker.com/_/php)
- [MySQL Docker Images](https://hub.docker.com/_/mysql)