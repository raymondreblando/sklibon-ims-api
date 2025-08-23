# SK Libon Information Management System API

This is the backend API for the Information Management System for the SK Federation of Libon, Albay.

## Features

*   **Authentication:** User authentication and authorization using Laravel Sanctum.
*   **Position Management:** CRUD operations for managing positions within the organization.
*   **Hotline Management:** CRUD operations for managing hotlines.
*   **Contact Management:** CRUD operations for managing contacts.
*   **Request Type Management:** CRUD operations for managing request types.
*   **Request Management:** CRUD operations for managing requests.
*   **Report Management:** CRUD operations for managing reports.
*   **Attachment Management:** CRUD operations for managing attachments.
*   **Gallery Management:** CRUD operations for managing galleries.

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

*   `POST /auth/register`: Register a new user
*   `POST /auth/login`: User login
*   `POST /auth/logout`: User logout
*   `POST /auth/refresh-token`: Refresh an expired access token

### Positions

*   `GET /positions`: Get a list of all positions.
*   `GET /positions/{id}`: Get a specific position by ID.
*   `POST /positions`: Create a new position.
*   `PUT /positions/{id}`: Update a position.
*   `DELETE /positions/{id}`: Delete a position.

### Users

*   `GET /users`: Get a list of all users.
*   `GET /users/{id}`: Get a specific user by ID.
*   `POST /users`: Create a new user.
*   `PUT /users/{id}`: Update a user.
*   `DELETE /users/{id}`: Delete a user.

### Account

*   `PUT /account/change-password`: Change the user's password.
*   `POST /account/change-profile-picture`: Change the user's profile picture.

### Locations

*   `GET /locations/provinces`: Get a list of all provinces.
*   `GET /locations/municipalities/{province_id}`: Get a list of all municipalities in a province.
*   `GET /locations/barangays/{municipality_id}`: Get a list of all barangays in a municipality.

### Hotlines

*   `GET /hotlines`: Get a list of all hotlines.
*   `GET /hotlines/{id}`: Get a specific hotline by ID.
*   `POST /hotlines`: Create a new hotline.
*   `PUT /hotlines/{id}`: Update a hotline.

### Contacts

*   `GET /contacts`: Get a list of all contacts.
*   `GET /contacts/{id}`: Get a specific contact by ID.
*   `POST /contacts`: Create a new contact.
*   `PUT /contacts/{id}`: Update a contact.
*   `DELETE /contacts/{id}`: Delete a contact.

### Request Types

*   `GET /request-types`: Get a list of all request types.
*   `GET /request-types/{id}`: Get a specific request type by ID.
*   `POST /request-types`: Create a new request type.
*   `PUT /request-types/{id}`: Update a request type.
*   `DELETE /request-types/{id}`: Delete a request type.

### Requests

*   `GET /requests`: Get a list of all requests.
*   `GET /requests/{id}`: Get a specific request by ID.
*   `POST /requests`: Create a new request.
*   `PUT /requests/{id}`: Update a request.
*   `DELETE /requests/{id}`: Delete a request.

### Reports

*   `GET /reports`: Get a list of all reports.
*   `GET /reports/{id}`: Get a specific report by ID.
*   `POST /reports`: Create a new report.
*   `PUT /reports/{id}`: Update a report.
*   `DELETE /reports/{id}`: Delete a report.

### Attachments

*   `POST /attachments`: Upload an attachment.
*   `DELETE /attachments/{id}`: Delete an attachment.

### Galleries

*   `GET /galleries`: Get a list of all galleries.
*   `GET /galleries/{id}`: Get a specific gallery by ID.
*   `POST /galleries`: Create a new gallery.
*   `PUT /galleries/{id}`: Update a gallery.
*   `DELETE /galleries/{id}`: Delete a gallery.

### Gallery Images

*   `POST /gallery-images`: Upload a gallery image.
*   `DELETE /gallery-images/{id}`: Delete a gallery image.

### Events

*   `GET /events`: Get a list of all events.
*   `GET /events/{id}`: Get a specific event by ID.
*   `POST /events`: Create a new event.
*   `PUT /events/{id}`: Update an event.
*   `DELETE /events/{id}`: Delete an event.

### Notifications

*   `GET /notifications`: Get a list of all notifications.
*   `PUT /notifications/{id}`: Update a notification.


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
*   **Policies:** The authorization policies are located in the `app/Policies` directory.
