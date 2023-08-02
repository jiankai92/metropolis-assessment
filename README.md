# Metropolis Assessment application

### Prerequisites
These prerequisites are required to run this project on a local server

- PHP ( ~v8.1 )
- MySQL
- Composer (~v2)
- Node.js
- NPM ( ~ v9 )
- Apache or nginx webserver (optional)

## Running this Repository On Local server

1. Clone this repository to your php webserver directory or any directory
2. Using terminal application, run `composer install` and `npm install` command in the project root directory to install
   required dependencies.
3. After dependencies are installed, run `npm run build` in project root directory to build required assets.
4. Run `cp .env.example .env` followed by `php artisan key:generate` to generate the `.env` file and also the key
   required for project.
5. After generating the `.env` file, setup the database connection by defining the database credentials in the `.env`
   file Sample:

````
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=dbpassword
````
6. Once credentials is defined, run `php artisan migrate` to create the required database tables.
7. If you cloned the project on your webserver directory, the project can now be opened
   at `http://<your-webserver-host>/path/to/metropolis-project`. Else using terminal, run `php artisan serve` at the
   root of the project. The project will now be accessible at `http://127.0.0.1:8000`.

### Setting up admin login user

1. Once the setup above is complete. At the project root directory run `php artisan db:seed`.
2. Once the command is ran, the user will be created and you may login using the following credentials:

````
Email: admin@email.com
Password: adminpassword1 
````
