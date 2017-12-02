# Gamazon
A market place for PS4 games  
Demo: http://gamazon.herokuapp.com/home

Reference
------
MAMP  
https://www.mamp.info/en/downloads/  
Laravel tutorials  
https://www.lynda.com/Laravel-tutorials/Learning-Laravel-4/166513-2.html?org=sjlibrary.org  
PhpStorm for student  
https://www.jetbrains.com/student/  
PhpStorm ide helper  
http://oomusou.io/phpstorm/phpstorm-ide-helper/  
PhpStorm Xdebug  
https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html  
Bootstrap and Laravel 5 tutorial  
https://medium.com/@chensformers/complete-guide-to-phpgrid-laravel-5-and-bootstrap-3-integration-for-beginners-c20b4ddd91e9  

Installation
------
1. Install MAMP
2. Follow Laravel tutorials to install Laravel
3. Install PhpStorm
4. Install PhpStorm IDE helper
5. Install Xdebug
6. Clone this project
7. Set your MAMP web server document root to [this project directory]/public

8. Edit run configuration
    1. Click on Run->Edit Configurations
    2. Add a PHP web application
    3. Click on Server "..." button
    4. Type "localhost" at the Host field and click OK
    5. Type "/" at the Start URL field and click OK

Instruction
------
1. Create a database called gamazon
2. $ cd [Gamazon root directory]
3. $ php artisan migrate
4. Run create_db.sql
5. Launch the web application by clicking on Run->Run or by visiting http://localhost/

Deploy Laravel onto Heroku
------
1.  Create database (ClearDB, JawDB)
2.  Paste the following code in web.php
```php
	 Route::get('/', function () {
	     return Redirect::route('home');
	 });
```
3.  Comment Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class in config/app.php
4.  $ echo web: vendor/bin/heroku-php-apache2 public/ > Procfile
5.  $ git add .
6.  $ git commit -am ""
7.  $ heroku create
8.  $ php artisan key:generate --show
9.  $ heroku config:set APP_KEY= [key]
10. $ git push heroku master
 
