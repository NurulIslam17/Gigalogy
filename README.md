
## Project Setup

### Step 1: Install Required Software

- PHP
- Composer
- Database (Postgres or MySQL)

### Step 2: Clone the GitHub Repository

- https://github.com/NurulIslam17/Gigalogy.git

### Step 3: Install Dependencies

- composer install (Run in terminal)

### Step 4: Create a Copy of the Environment File

Duplicate the .env.example file and save it as .env:

Open the .env file and configure the database connection and any other necessary settings.

### Step 5: Generate Application Key
Generate the application key using the following command:

- php artisan key:generate (Run in terminal)

### Step 6: Run Migrations
Execute the following command to run the database migrations:
- php artisan migrate (Run in terminal)

### Step 7: Serve the Application
Execute the following command to run the database migrations:To run the Laravel development server, use the following command:
- php artisan serve (Run in terminal)


## GMAIL API EMAIL SENDING IN LARAVEL — FULL SETUP

### Step 1: Enable Gmail API
- Go to Google Cloud Console ( https://console.cloud.google.com/)
- Create a New Project → Select it.
- Go to APIs & Services → Library
- Search Gmail API → Click Enable

### Step 2: Open OAuth Consent Screen
Create User type and App Information
- User Type: External

### Step 3: Create OAuth Credentials
- Go to APIs & Services → Credentials
- Click Create Credentials → OAuth Client ID (Note: Auth redirect URI should be like : App_base_url/callback , Example: http://127.0.0.1:8000/callback , while creating Client ID)
- App Type → Desktop App
- Download the JSON file: after finishing the download rename it credentials.json

### Step 4: Put credentials.json in Laravel
- Create folder: storage/app/google (Path of the folder )
- File path like : storage/app/google/credentials.json

### Step 5: Install Google API Client Package
- Run : composer require google/apiclient:^2.13

### Step 6: Generate Token
- Run : php artisan gmail:token
  Then 
- Open URL → Login with Gmail → Allow Access
- Copy authorization code
- Paste in terminal
- It creates: storage/app/google/token.json

## Docker SETUP

### .env setup

        DB_CONNECTION=pgsql
        DB_HOST=db
        DB_PORT=5432
        DB_DATABASE=db_name
        DB_USERNAME=db_user_name
        DB_PASSWORD=db_user_password

### Run command
- Run Docker: docker-compose up --build
- Run Migrations: docker exec -it laravel_app php artisan migrate
- Remove container: docker-compose down -v (Optinal)
- Re-run : docker-compose down -d (if required)


## POSTMAN SETUP

### Send request to
- http://127.0.0.1:8000/api/register (base_url/api/register)
- JSON Format is
       {
            "name":"User Name",
            "email":"validemail@gmail.com",
            "password":"user_password"
        }
- http://127.0.0.1:8000/api/users (base_url/api/register) to fetch users list


## Final Check
- Check Database server is active
- Run : php artisan serve (Not required if using docker)
- Run : php artisan queue:work (Not required if using docker)





















