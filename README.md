# Product Module Setup Guide
This repository contains a Laravel v10 project. Follow the steps below to set up and run the project on your local machine.

1. *Prerequisites: Before you begin, make sure you have the following installed on your system.*
   - PHP (>=8.1.0)
   - Composer (>=2.2.0)
   - Node.js (with npm or yarn)
   - MySQL or any other compatible database system

2. *Installation Steps: Clone the Repository.*
```
   git clone https://github.com/ashishradadiya/product-module-laravel.git
```

3. *Navigate to Project Directory:*
```
   cd product-module-laravel
```

4. *Install PHP Dependencies:*
```
   composer install
```
  
5. *Copy Environment File:*
```
   cp .env.example .env
```
 
6. *Generate Application Key:*
```
   php artisan key:generate
```

7. *Update Environment Variables:*
   - Open the .env file and update the database connection details according to your system configuration.

8. *Run Migrations:*
```
   php artisan migrate
```

9. *Seed Data (Follow the sequence as below):*
```
   php artisan db:seed --class=CategorySeeder
```

10. *Link the storage:*
```
   php artisan storage:link
```

11. *Serve the Application:*
```
   php artisan serve
```

12. *Access the Application:*
   - Visit http://localhost:8000 in your web browser to access the application.

13. *Additional Steps*
    - If you want to use a different server configuration (e.g., Apache, Nginx), configure it to point to the public directory of the project.
    - For advanced usage, refer to the Laravel documentation: https://laravel.com/docs/10.x

14. *Troubleshooting*
    - If you encounter any issues during installation or setup, please check the Laravel documentation or search for solutions online. If the problem persists, feel free to open an issue in this repository.

15. *Contributing*
    - Contributions are welcome! If you find any bugs or want to suggest improvements, please open an issue or submit a pull request.