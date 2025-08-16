# SK Libon Information Management System API

This is the backend API for the Information Management System for the SK Federation of Libon, Albay.

## Features

*   **Authentication:** User authentication and authorization using Laravel Sanctum.
*   **Position Management:** CRUD operations for managing positions within the organization.

## Project Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/sklibon-ims-api.git
    cd sklibon-ims-api
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Set up your environment:**
    -   Copy the `.env.example` file to a new file named `.env`.
    -   Update the database credentials and other environment variables in the `.env` file.
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run database migrations:**
    ```bash
    php artisan migrate
    ```

6.  **Seed the database (optional):**
    ```bash
    php artisan db:seed
    ```

7.  **Run the development server:**
    ```bash
    php artisan serve
    ```

## API Endpoints

All API endpoints are prefixed with `/api/v1`.

### Authentication

*   `POST /auth/login`: User login

### Positions

*   `GET /positions`: Get a list of all positions.
*   `GET /positions/{id}`: Get a specific position by ID.
*   `POST /positions`: Create a new position.
*   `PUT /positions/{id}`: Update a position.
*   `DELETE /positions/{id}`: Delete a position.

## Custom Artisan Commands

*   `php artisan make:repository {name} --model={model}`: Create a new repository and its corresponding eloquent implementation.
*   `php artisan make:service {name} --repository={repository}`: Create a new service class.

## User Roles

The system has the following user roles:

*   **Super Admin:** Has all permissions.
*   **Admin:** Has most permissions, but cannot manage other admins.
*   **User:** Has limited permissions.

## Important Aspects

*   **API Endpoints:** All API endpoints are defined in `routes/api.php`.
*   **Authentication:** The API uses Laravel Sanctum for authentication.
*   **Database:** The project uses a MySQL database.
*   **Models:** The database models are located in the `app/Models` directory.
*   **Controllers:** The API controllers are located in the `app/Http/Controllers` directory.
