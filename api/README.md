# Laravel API Setup with Docker

This guide walks you through setting up a Laravel-based API project using Docker. Follow the steps below to get your environment running and test the API.

## Prerequisites

Before starting, ensure you have the following installed on your local machine:

- Docker
- Docker Compose
- PHP (optional, if not using Docker for everything)

## Setup Instructions

### 1. Start the Docker Containers

To start the Docker containers for your Laravel API and the database, run the following command:

```bash
sudo docker-compose up
```

Once the containers are running, you need to configure the environment variables for the application.

Open your .env file and update the following database-related variables:

DB_CONNECTION=mysql
DB_HOST=172.27.0.3
DB_PORT=3306
DB_DATABASE=store-api
DB_USERNAME=root
DB_PASSWORD=root

If DB_HOST in the .env file is incorrect, find the correct IP address of the database container by running the following command:

```bash
sudo docker inspect db-store-api
```
Look for the IPAddress under the container's network settings. Once you get the correct IP, update the DB_HOST variable in your .env file.


After updating the environment variables, access the app container to run the necessary commands:
```bash
sudo docker exec -it app-store sh
```


Inside the container, run the following command to install all the PHP dependencies:
```bash
composer install
```

Once the dependencies are installed, run the database migrations and seeders to set up your database:
```bash
php artisan migrate --seed
```

Finally, run the tests to ensure everything is working correctly:
```bash
php artisan test
```

