## This Repo is outdated So please use Latest version of this repository here.

<a href="https://github.com/walkswithme/laravel-admin">WWM Laravel Admin ** (Laravel 6.* LTS version) **</a>

# Laflux Platform

Laflux is a Hybrid Platform built with Laravel 5.3.

## Getting Started

Laflux can be used to develope small websites to large enterprise applications.
Laflux provides a basic platform for ERP, CRM, CMS or Ecommerce applications. You can easily customize the platform for your own needs. Comparing to other Laravel based frameworks, it's a greate advantage. Unlike other, this platform can be upgraded to latest version of Laravel, whenever there is a new update.Click here for the [Demo](http://demo.laflux.com/admin/dashboard). Default Username : demo@laflux.com, Password : 123456.

### Prerequisites

PHP and Laravel Knowledge

### Installing

1.) Download the zip and extract it to a directory or Clone the repository to a directory.

2.) Create a databse and give the credentials in the .env file existing in the root directory.

3.) Run the following commands from the terminal in the root directory.


Submodule's initializations
```
git submodule init
git submodule update
git submodule foreach git pull origin master //This only required for getting updated submodule
```

Composer modules initializations
```
composer install

```

Migrations and Seeders initializations
```
php artisan vendor:publish
php artisan migrate
php artisan db:seed
composer dumpautoload -o
```


## Deployment

You can deploy laflux, anywhere.

## Built With

* [LARAVEL](https://laravel.com/) - The web framework used
* [COMPOSER](https://getcomposer.org/) - Dependency Management

## Authors

* **Jobin Jose** - *Initial work* - [Jobin Jose](https://github.com/Jobinjose01)
* **Jinto Antony** - *Initial work* - [Jinto Antony](https://github.com/JintoAntony)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Laflux platform Documentation - [Documentation](http://docs.laflux.com/)
* Updates - Pull this repository for latest updates
* Premium Version of Laflux Platform - [Premium Version](http://extensionsvalley.com/downloads/laravel-admin-dashboard/)

### Premium Version features:
* 100% Upgrade Guaranteed
* Laravel 5.2 or 5.3 to Kick Start
* User Management
* User Groups Management
* Powerful Access Control Logic (ACL)
* Inbuilt Data Tables Support
* Easy CRUD Management
* Extension Manager for integrating many packages
* Data Export options for all Tables
* Rapid Customization Options
* Full Admin Theme
* Clean and Professional UI
* Inbuilt CSS3, HTML5, Bootstrap Support
* Free Lifetime Updates
* Comparable with All-Modern-Browsers
* Multiple Icon Fonts
* Retina-Ready Design
* etc.


