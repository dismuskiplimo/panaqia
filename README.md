## Panaqia Laravel Application

## Table of Contents

* [About the Project](#about-the-project)
* [Built With](#built-with)
* [Prerequisites](#prerequisites)
* [Getting Started](#getting-started)
* [Contributing](#contributing)
* [Authors](#author)
* [Acknowledgements](#acknowledgements)

## About The Project





## [Live Demo - Heroku](https://panaqia.herokuapp.com/)
<!-- ## [Live Demo ]() -->

## Built With

* PHP
* Laravel
* MySQL Server (any supported RDBMS can be used)

## Prerequisites

- PHP 7.1 or later (best if also added to the env path for direct access with the terminal)
- MySQL Server, PsotgreSQL, or any other RDBMS supported by Laravel
- Composer
- Text Editor - Visual Studio Code recommended
- MPESA Daraja API credentials (https://developer.safaricom.co.ke/)

## Getting Started

* Clone this repo <https://github.com/dismuskiplimo/panaqia.git>

    bash
    git clone <https://github.com/dismuskiplimo/panaqia.git>
    

* Navigate to panaqia folder/directory

    bash
    cd panaqia
    
* Clone the project into your local machine
* Navigate into the project folder
* Rename `.env.example` to become `.env`
* Open the `.env` file using your favourite text editor. This file contains necessary configuration data for the application to run
* You need only to edit the `DB` section e.g `DB_DATABASE`,`DB_USERNAME`,`DB_PASSWORD`, for the application to finish installing. You need to make sure the database selected is already created in MySQL server.
* Open terminal within the project folder and type in the following commands in order
* `php artisan key:generate` to generate application keys
* `composer install` to install all the dependencies.
* `php artisan migrate` to create the tables in MySQL
* `php artisan db:seed` to populate the database with system configuration data
* You're done 👍
* Now, run `php artisan serve` to launch a development server.
* Navigate to `http://localhost:8000` to view the website

## Contributing

Contributions, issues, and feature requests are welcome!

Feel free to check the [issues page](../../issues)

  1. Fork the Project
  2. Create your Feature Branch (`git checkout -b feature/newFeature`)
  3. Commit your Changes (`git commit -m 'Add some newFeature'`)
  4. Push to the Branch (`git push -u origin feature/newFeature`)
  5. Open a Pull Request

## Authors

👤 *Dismus Ng'eno*

- GitHub: [@dismuskiplimo](https://github.com/dismuskiplimo)
- Twitter: [@dismus_kiplimo](https://twitter.com/dismus_kiplimo)
- LinkedIn: [Dismus Ng'eno](https://www.linkedin.com/in/dismus-kiplimo)

## Acknowledgements

* [Laravel Team](https://laravel.com/) for the amazing [Documentation](https://laravel.com/docs/master/introduction) on Laravel.

## Show your support

Give a ⭐ if you like this project!
