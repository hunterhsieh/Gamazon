# Gamazon
A market place for PS4 games  
Demo: http://gamazon.herokuapp.com/home

Introduction
------
Gamazon is a website for PS4 gamers to review and rate games made by different companies, and receive promo code for a game discount. The purpose of Gamazon is offer a critical view of how a PS4 game succeeds or fails at what it’s trying to do, give users all the info needed to determine if a PS4 game is worth their time and hard-earned cash,  and users will have chance to get discount of a game. Both PS4 game produce companies and all the PS4 gamers are our intended users.
We choose to use PHP as our primary programming language, and Laravel as our framework for the entire project. In addition, we deploy Gamazon on Heroku (PaaS) and connect it with both SQL (MySQL) and NOSQL (Mongo dB) database to store our data. 

Functions
------
As the functionalities we have stated in the proposal, we have complete all functions we planned to do. When register, user can choose to create either a gamer account or company account. The password will be hashed before saved into database. Each account will have different access and features. Gamer account will be able to visit, review, rate and like other gamer’s review. In addition, gamers will be divided into three different ranking, Bronze, Silver and Gold. A Gamer will be able to promote into silver level if the average likes from all reviews are more than 5, and promote into gold level if the average likes from all reviews are more than 15. Gamazon will send out 10% off coupon for gamers when a gamer promote to Silver, and 20% off coupon when a gamer promote to Gold. Other than Gamer account, Company account can only add products. And each company will have its own page which present five most popular products. 
In addition, the front page of Gamazon will recommend five most popular product (based on the stars of review). It also allow gamers to specify the order of game list by the number of reviews, visits, or products with highest rate. Furthermore, a search engine is provided by Gamazon. Gamers can search their interesting products by companies, categories (action, sports, strategy, etc), price or keyword. 


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
 
