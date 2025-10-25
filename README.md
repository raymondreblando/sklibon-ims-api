# SK Libon Information Management System API

The SK Libon Information Management System API is the backend for a comprehensive platform designed to streamline the operations of the Sangguniang Kabataan (SK) Federation of Libon, Albay. This system provides a centralized database and a set of tools to manage information, communication, and activities within the SK organization.

## Features

*   **Authentication:** Secure user authentication and authorization using Laravel Sanctum, with support for refresh tokens.
*   **User Management:** CRUD operations for users, with role-based access control (Super Admin, Admin, User).
*   **Position Management:** CRUD operations for managing positions within the organization.
*   **Event Management:** Create, manage, and track attendance for events and activities.
*   **Request Management:** A system for managing and tracking requests from constituents, with different request types.
*   **Report Generation:** Generate reports, such as attendance reports for events.
*   **Communication Tools:** Real-time chat functionality (private and group chats) and a notification system.
*   **Information Management:** Manage hotlines, contacts, and a gallery for photos.
*   **Location-Based Services:** Access to a database of provinces, municipalities, and barangays.
*   **File Management:** Upload and manage attachments for various resources.
*   **Dashboard:** A dashboard providing statistical insights into the system's data.

## Project Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/raymondreblando/sklibon-ims-api.git
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
*   `GET /auth/imagekit`: Get ImageKit authentication parameters

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

### Roles
*   `GET /roles`: Get a list of all roles.

### Dashboard
*   `GET /dashboard/statistics`: Get dashboard statistics.

### Account

*   `PUT /account/change-password`: Change the user's password.
*   `PUT /account/change-profile-picture`: Change the user's profile picture.
*   `PUT /account/update-profile`: Update the user's profile.
*   `PUT /account/change-password/{id}`: Change a specific user's password.
*   `PUT /account/change-profile-picture/{id}`: Change a specific user's profile picture.

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

### Archives
*   `GET /archives`: Get a list of all archives.
*   `DELETE /archives/{id}`: Delete an archive.

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

### Attendances

*   `GET /attendances`: Get a list of all attendances.
*   `PUT /attendances/{eventId}`: Mark attendance for an event.

### Events

*   `GET /events`: Get a list of all events.
*   `GET /events/{id}`: Get a specific event by ID.
*   `POST /events`: Create a new event.
*   `PUT /events/{id}`: Update an event.
*   `DELETE /events/{id}`: Delete an event.

### Notifications

*   `GET /notifications`: Get a list of all notifications.
*   `PUT /notifications/{id}`: Update a notification.

### Chats
*   `GET /chats`: Get a list of all chats.
*   `GET /chats/count`: Get the number of unread messages.
*   `POST /chat/privates`: Create a private chat.
*   `POST /chat/group-chats`: Create a group chat.
*   `PUT /chats/{chat}`: Send a message to a chat.
*   `GET /chats/{chat}`: Get all messages from a chat.

### Chat Members
*   `GET /chat/members`: Get a list of all chat members.
*   `POST /chat/members`: Add a member to a chat.
*   `DELETE /chat/members/{id}`: Remove a member from a chat.

### SK Officials
*   `GET /sk-officials/{barangayCode}`: Get a list of all SK officials in a barangay.

### Generate Reports
*   `GET /generate-reports/attendance`: Generate an attendance report.

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
