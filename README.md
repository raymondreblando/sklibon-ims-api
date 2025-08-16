# SK Libon Information Management System API

This is the backend API for the Information Management System for the SK Federation of Libon, Albay.

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

## Important Aspects

*   **API Endpoints:** All API endpoints are defined in `routes/api.php`.
*   **Authentication:** The API uses Laravel Sanctum for authentication.
*   **Database:** The project uses a MySQL database.
*   **Models:** The database models are located in the `app/Models` directory.
*   **Controllers:** The API controllers are located in the `app/Http/Controllers` directory.