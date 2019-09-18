## Laravel 5 example with Crud operation ##

For Laravel 5.8 improved version look at [this repository](https://github.com/tbsphpdev/Laraval-5.8-Admin-Authentication-And-CRUD-Opration-Demo).

### Requirements ###
* **OS:** Ubuntu 16.04 LTS or higher / Windows 7 or Higher (WAMP / XAMP).
* **SERVER:** Apache 2 or NGINX.
* **RAM:** 3 GB or higher.
* **PHP:** 7.1.3 or higher.
* **For MySQL users:** 5.7.23 or higher.
* **Composer:** 1.6.5 or higher.

### Installation ###

* Download Project 
* `cd projectname`
* `composer install`
* `php artisan key:generate`
* Set env development/production in `config->app` 
* Create a database and set name in  `config->database` 
* `php artisan migrate --seed` to create and populate tables
* `php artisan serve` to start the app on http://localhost:8000/

### Include ###

* [Bootstrap](http://getbootstrap.com) for CSS and jQuery plugins
* [Font Awesome](http://fortawesome.github.io/Font-Awesome) for the nice icons
* [bootstrap-notify.js](http://bootstrap-notify.remabledesigns.com/) for highlighting code
* [Admin Lte](https://adminlte.io/themes/AdminLTE/index2.html) for the free templates
* [Datatables](https://datatables.net/) the great editor

### Features ###

* Login page
* Admin Authentication (login, logout)
* Users Crud opration : create user, update user information, change user status and delete user 
* Admin dashboard with current registerd user
*  Content Crud operation : Add content, update content and delete content