# FuSUsApp
Fuzzy Software Usability Application.

Author: Tomas Bodnar <bodnarto@gmail.com>

&copy; 2020 MIT License

FuSUsApp is powered by Laravel.

## How to run app locally in docker
1. `cd docker` && `./docker-setup.sh`
2. Add following lines to `/etc/hosts` on Linux:
    ```
    172.0.51.2 fususapp.test
    172.0.51.3 db.fususapp.test
    172.0.51.4 adminer.fususapp.test
    172.0.51.5 pma.fususapp.test
    172.0.51.6 mc.fususapp.test
    ```
   or `C:\Windows\System32\drivers\etc\hosts` on Windows:
   ```
   127.0.51.2 fususapp.test
   127.0.51.3 db.fususapp.test
   127.0.51.4 adminer.fususapp.test
   127.0.51.5 pma.fususapp.test
   127.0.51.6 mc.fususapp.test
   ```
* Copy paste .env.example to .env (no need to set anything)
* Exec into container: `docker exec -it fususapp_app bash`

## How to run app 
* Copy files to web server with PHP >=7.2.5
* Set document root to directory `/public`
* Copy paste .env.example to .env and set proper DB credentials
* Run composer install: `composer install`
* Run npm: `npm install && npm run dev`
* Run database migrations to create tables: `php artisan migrate`

## Example of FuSUsApp usage
* Run random data generator to create testing data: `php artisan db:seed --class=RandomDataSeeder`
* Run command to get aggregated data: `php artisan fususapp:run`
* Basic UI is available at [http://fususapp.test](http://fususapp.test)

## About Laravel

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>


Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

FuSUsApp is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
