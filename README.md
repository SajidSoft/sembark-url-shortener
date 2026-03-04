# Sembark URL Shortener - Assignment

# Tech Stack
 - Laravel 10
 - MySQL
 - Barebones HTML

 # Local Setup Instructions

 Follow these steps to run the application locally for testing:

 1. Clone the repository
  - git clone [https://github.com/SajidSoft/sembark-url-shortener.git/]
  - cd sembark-url-shortener

2. composer install

3. cp .env.example .env
4. php artisan key:generate

5. php artisan migrate --seed

6. php artisan serve

The application will be accessible at http://localhost:8000

# Test Credentials
After running the seeder, use the following credentials to access the SuperAdmin panel and start creating companies/users:
    Role: Super Admin
    Email: superadmin@sembark.com (Update this if your seeder used a different email)
    Password: password (Update this if your seeder used a different password)

