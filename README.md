# Task Management Application - Server

The server-side component of the Task Management Application built with Laravel. This application provides a robust API and real-time features using Laravel Echo and Pusher.

## Tech Stack

-   Laravel (Latest Version)
-   PHP 8.x
-   MySQL/PostgreSQL
-   Laravel Echo Server
-   Pusher
-   Laravel Sanctum (API Authentication)

## Prerequisites

-   PHP 8.x
-   Composer
-   MySQL or PostgreSQL
-   Node.js & NPM (for asset compilation)

## Installation

1. Clone the repository
2. Navigate to the server directory:
    ```bash
    cd web/server
    ```
3. Install PHP dependencies:
    ```bash
    composer install
    ```
4. Install Node dependencies:
    ```bash
    npm install
    ```
5. Create environment file:
    ```bash
    cp .env.example .env
    ```
6. Generate application key:
    ```bash
    php artisan key:generate
    ```
7. Configure your database in `.env` file:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
8. Configure Pusher credentials in `.env` file:
    ```env
    PUSHER_APP_ID=your_app_id
    PUSHER_APP_KEY=your_app_key
    PUSHER_APP_SECRET=your_app_secret
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=your_app_cluster
    ```
9. Run database migrations:
    ```bash
    php artisan migrate
    ```

## Development

1. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

    The API will be available at `http://localhost:8000`

2. Start Vite development server (for assets):
    ```bash
    npm run dev
    ```

## Production Deployment

1. Build assets for production:

    ```bash
    npm run build
    ```

2. Configure your web server (Apache/Nginx) to point to the `public` directory

3. Set appropriate permissions:

    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

4. Configure your production environment variables in `.env`

## API Documentation

The API endpoints are organized in the following structure:

### Authentication

-   POST `/api/login` - User login
-   POST `/api/register` - User registration
-   POST `/api/logout` - User logout

### Tasks

-   GET `/api/tasks` - List all tasks
-   POST `/api/tasks` - Create a new task
-   GET `/api/tasks/{id}` - Get task details
-   PUT `/api/tasks/{id}` - Update task
-   DELETE `/api/tasks/{id}` - Delete task

## Features

-   RESTful API architecture
-   Real-time updates with Laravel Echo and Pusher
-   API authentication using Laravel Sanctum
-   Database migrations and seeders
-   Event broadcasting
-   CORS configuration
-   Comprehensive error handling

## Testing

Run the test suite:

```bash
php artisan test
```

## Directory Structure

```
app/
  ├── Http/
  │   ├── Controllers/  # API Controllers
  │   └── Middleware/   # Custom Middleware
  ├── Models/          # Eloquent Models
  ├── Events/          # Event Classes
  └── Providers/       # Service Providers

routes/
  └── api.php         # API Routes

database/
  ├── migrations/     # Database Migrations
  └── seeders/        # Database Seeders
```

## Security

-   All API endpoints are protected with Laravel Sanctum
-   CORS is configured for the client application
-   Environment variables are used for sensitive data
-   Input validation and sanitization
-   SQL injection protection

## Error Handling

The API returns standard HTTP status codes and JSON responses:

```json
{
    "status": "error",
    "message": "Error message here",
    "errors": {}
}
```

## License

This project is licensed under the MIT License.
