# All New SATRIA Project

All New SATRIA is a comprehensive web application for managing and tracking "Surat Jalan" (Delivery Orders) with advanced workflow features for logistics and finance departments.

## 📋 Overview

SATRIA (Surat Jalan Tracking and Reporting Integrated Application) is a Laravel-based web application designed to streamline the management of delivery orders within an organization. The system provides real-time tracking, reporting, and workflow automation for Surat Jalan documents from creation to financial processing.

## ✨ Key Features

### 📊 Surat Jalan Management
- **Complete CRUD Operations**: Create, Read, Update, and Delete Surat Jalan records
- **Excel Import/Export**: Bulk upload and download of Surat Jalan data using Excel files
- **Real-time Tracking**: Monitor the status of each delivery order in real-time
- **Advanced Filtering**: Filter records by date ranges and specific criteria

### 🔄 Workflow Automation
- **SJ Balik Tracking**: Track when delivery orders are returned
- **Finance Department Integration**: Mark when documents are received by finance
- **Role-based Access**: Different interfaces for PPIC, PC, and Finance departments
- **Automated Status Updates**: Automatic timestamping for workflow milestones

### 📈 Reporting & Analytics
- **Outstanding SJ Dashboard**: View all pending delivery orders
- **Custom Reports**: Generate reports based on various criteria
- **Data Visualization**: Clear tabular displays with sorting and pagination
- **Export Capabilities**: Export data for external analysis

### 👥 User Management
- **Role-based Permissions**: 
  - PPIC/PC: Can scan and update SJ Balik status
  - Finance: Can mark documents as received
- **Secure Authentication**: Laravel-based authentication system
- **Activity Tracking**: Monitor user actions and changes

## 🏗️ Technology Stack

### Backend
- **PHP 8.1+** with **Laravel 10** framework
- **MySQL** database for data storage
- **Maatwebsite Excel** for spreadsheet operations
- **Yajra DataTables** for advanced table functionality
- **Barryvdh Debugbar** for development debugging

### Frontend
- **Bootstrap 3** for responsive UI design
- **jQuery** for interactive elements
- **DataTables** for enhanced table features
- **Vue.js 1.0** for reactive components
- **Gulp** for asset compilation

### Infrastructure
- **Docker** containerization for easy deployment
- **Nginx** web server with PHP-FPM
- **Supervisor** for process management
- **MySQL 8.0** database server

## 📁 Database Schema

The application manages the following key data:

### Surat Jalan (sjs table)
- `tanggal_delivery`: Delivery date
- `customer_name`: Customer information
- `pdsnumber`: PDS reference number
- `doaii`: DOAII identifier
- `sj_balik`: Timestamp when SJ is returned
- `terima_finance`: Timestamp when finance receives document
- Automated `created_at` and `updated_at` timestamps

## 🚀 Installation & Deployment

### Prerequisites
- Docker and Docker Compose
- PHP 8.1+ (for local development)
- Composer (for dependency management)
- Node.js and NPM (for frontend assets)

### Quick Start with Docker
```bash
# Clone the repository
git clone <repository-url>
cd satria-eko

# Build and start the application
docker-compose -f docker-compose.prod.yml up -d

# The application will be available at http://localhost:80
```

### Manual Installation
```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install frontend dependencies
npm install

# Build assets
npm run prod

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Set permissions
chmod -R 775 storage bootstrap/cache
```

## 🔧 Configuration

### Environment Variables
Key configuration options in `.env`:
- `APP_ENV`: Application environment (production/development)
- `APP_DEBUG`: Debug mode toggle
- `DB_*`: Database connection settings
- `SESSION_DRIVER`: Session storage driver

### Docker Configuration
- **Production**: Uses optimized PHP settings with opcache enabled
- **Development**: Includes debug tools and development dependencies
- **Database**: MySQL 8.0 with proper configuration for Laravel

## 📱 Usage Guide

### For PPIC/PC Department
1. Access the main dashboard to view all Surat Jalan
2. Use the "Scan Disini >> SJ BALIK & Ke Finance" button to update return status
3. Filter records by date range for specific reporting periods
4. Upload Excel files for bulk data import

### For Finance Department
1. Access the finance-specific interface
2. Mark documents as received by finance
3. Track which documents have been processed
4. Generate reports for accounting purposes

### General Users
1. View Surat Jalan status and details
2. Search and filter records
3. Export data for external use
4. Monitor workflow progress

## 🛡️ Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **SQL Injection Prevention**: Laravel's Eloquent ORM with parameter binding
- **XSS Protection**: Blade template engine auto-escaping
- **Secure Authentication**: Laravel's built-in authentication system
- **Input Validation**: Comprehensive validation for all user inputs
- **Role-based Access Control**: Restricted access based on user roles

## 📊 Data Management

### Import Process
1. Prepare Excel file with required columns
2. Upload via the web interface
3. System validates data format and duplicates
4. Records are imported with automatic timestamps

### Export Process
1. Apply filters as needed
2. Export to Excel format
3. Download file for offline use
4. Maintains data integrity and formatting

## 🔍 Monitoring & Maintenance

### Logging
- Application logs stored in `storage/logs/`
- Nginx access and error logs
- PHP-FPM error logging
- Laravel-specific logging channels

### Health Checks
- Docker container health checks
- Database connection monitoring
- Application availability monitoring
- Automated backup systems (recommended)

## 🤝 Contributing

We welcome contributions to the All New SATRIA project! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR coding standards
- Write clear commit messages
- Include tests for new features
- Update documentation as needed
- Ensure backward compatibility

## 🐛 Troubleshooting

### Common Issues

**Application shows 500 error:**
- Check storage directory permissions
- Verify database connection settings
- Clear configuration cache: `php artisan config:clear`

**Excel import fails:**
- Verify Excel file format matches template
- Check column headers are correct
- Ensure file size is within limits

**Docker containers won't start:**
- Check port availability (80, 3306)
- Verify Docker daemon is running
- Check disk space availability

### Getting Help
- Check the application logs in `storage/logs/`
- Review Docker container logs: `docker logs <container-name>`
- Verify environment configuration

## 📞 Support

For technical support or questions:
- **Email**: teguhyuhono10@gmail.com
- **Issues**: Please use the GitHub issue tracker
- **Documentation**: Refer to this README and code comments

## 🔒 Security Vulnerabilities

If you discover a security vulnerability within SATRIA, please send an email to Teguh Yuhono at teguhyuhono10@gmail.com. All security vulnerabilities will be promptly addressed.

## 📄 License

The All New SATRIA Project is open-sourced software licensed under the [MIT License](http://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- **Laravel Community** for the excellent framework
- **All Contributors** who have helped improve this project
- **Users** for their feedback and suggestions

---

*Last Updated: April 2026*  
*Version: 1.0*  
*Maintainer: Teguh Yuhono*
