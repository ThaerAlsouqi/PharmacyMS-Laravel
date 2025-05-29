# Pharmacy Management System

A comprehensive Laravel-based pharmacy management system for handling inventory, sales, customers, and vendors.

## 🚀 Features

- **Inventory Management**: Track medicines, stock levels, and expiry dates
- **Sales Management**: Process sales transactions and generate receipts
- **Customer Management**: Maintain customer records and purchase history
- **Vendor Management**: Manage supplier information and purchase orders
- **Admin Dashboard**: Complete administrative control panel
- **Reporting**: Generate various business reports

## 🛠 Installation

### Prerequisites
- PHP >= 8.0
- Composer
- Node.js & NPM
- MySQL Database

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/ThaerAlsouqi/PharmacyMS-Laravel.git
   cd PharmacyMS-Laravel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   - Create a MySQL database
   - Update `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile Assets**
   ```bash
   npm run dev
   # or for production
   npm run build
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Visit: `http://localhost:8000`

## 📁 Project Structure

```
├── app/                    # Application logic
├── bootstrap/              # Bootstrap files
├── config/                 # Configuration files
├── database/               # Migrations and seeders
├── public/                 # Public assets
├── resources/              # Views, CSS, JS
│   ├── views/
│   │   ├── admin/         # Admin panel views
│   │   ├── components/    # Reusable components
│   │   ├── customer/      # Customer views
│   │   ├── products/      # Product views
│   │   └── vendor/        # Vendor views
├── routes/                 # Route definitions
├── storage/                # File storage
└── tests/                  # Test files
```

## 🔧 Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
composer run phpcs
composer run phpcbf
```

### Database Operations
```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback
```

## 🚀 Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `composer install --optimize-autoloader --no-dev`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`
7. Configure web server (Apache/Nginx)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

