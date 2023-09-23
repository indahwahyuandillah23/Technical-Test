# Laravel Application for PT. Pasifik Satelit Nusantara Technical Test

This is a Laravel application built for PT. Pasifik Satelit Nusantara's technical test. It provides a platform for managing customer data and addresses.

## Getting Started

### Prerequisites

Before you begin, ensure you have met the following requirements:

- [Docker](https://www.docker.com/get-started) installed on your system.

### Running Locally

To run the Laravel application locally, follow these steps:

1. Clone this repository to your local machine:

   ```bash
   git clone https://github.com/your-username/your-repo.git
   ```

2. Navigate to the project directory:

   ```bash
   cd your-repo
   ```

3. Install the application dependencies:

   ```bash
   composer install
   ```

4. Create a `.env` file by copying `.env.example` and configure your database connection:

   ```bash
   cp .env.example .env
   ```

   Update the database configuration in the `.env` file with your database credentials.

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Run database migrations:

   ```bash
   php artisan migrate
   ```

7. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

8. Access the application in your web browser at `http://localhost:8000`.

### Using Docker

Alternatively, you can run this Laravel application in a Docker container. Make sure you have Docker installed on your system before proceeding.

1. Clone this repository to your local machine:

   ```bash
   git clone https://github.com/your-username/your-repo.git
   ```

2. Navigate to the project directory:

   ```bash
   cd your-repo
   ```

3. Build the Docker image:

   ```bash
   docker build -t laravel-app .
   ```

4. Create a `.env` file by copying `.env.example` and configure your database connection:

   ```bash
   cp .env.example .env
   ```

   Update the database configuration in the `.env` file with your database credentials.

5. Generate an application key:

   ```bash
   docker run --rm -it laravel-app php artisan key:generate
   ```

6. Start the Docker container:

   ```bash
   docker-compose up -d
   ```

7. Access the application in your web browser at `http://localhost:8000`.

## Usage

- Access the application's endpoints to manage customers and addresses.
- Perform CRUD operations on customers and their addresses.
- Enjoy exploring the features of the application.

## Testing

To run unit tests for the application, use the following command:

```bash
docker exec -it laravel-app phpunit
```

## Author

- Indah Wahyuandillah
- indahwahyuandillah930@gmail.com