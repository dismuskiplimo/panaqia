## Panaqia Laravel Application

![panaqia](https://user-images.githubusercontent.com/15145265/173414854-8feb95ca-029a-4c8f-87d3-3dbf3466506b.jpg)

## Table of Contents

* [About the Project](#about-the-project)
* [Built With](#built-with)
* [Prerequisites](#prerequisites)
* [Getting Started](#getting-started)
* [Installation](#installation)
* [Contributing](#contributing)
* [.env file configurations](#configuration-file)
* [Authors](#authors)
* [Acknowledgements](#acknowledgements)

## About The Project





### [Live Demo - Heroku](https://panaqia.herokuapp.com/)
N/B: The image upload feature does not work in the demo link because Heroku does not have the GD & exif libraries necessary for image upload and processing

## Built With

* PHP
* Laravel
* MySQL Server (any supported RDBMS can be used)

## Prerequisites

- PHP 7.1 or later (best if also added to the env path `$PATH` for easy access while using the terminal)
- MySQL Server, PsotgreSQL, or any other RDBMS supported by Laravel
- Composer
- Text Editor - Visual Studio Code recommended
- MPESA Daraja API credentials (https://developer.safaricom.co.ke/)

## Getting Started

* Clone this repo
    ```shell
    git clone https://github.com/dismuskiplimo/panaqia.git
    ```

* Navigate to panaqia folder/directory

    ```shell
    cd panaqia
    ```
* Rename `.env.example` to become `.env`
    ```shell
    mv .env.example .env
    ```
* Open the `.env` file using your favourite text editor. This file contains necessary configuration data for the application to run
* You need only to edit the `DB` section e.g `DB_DATABASE`,`DB_USERNAME`,`DB_PASSWORD`, for the initial installation. Ensure that the database selected is already created in your REBMS server (mysql, postgresql, sqlite e.t.c) or the installation will fail.

## Installation

After the `.env` configuration file has been updated, resume to the terminal and type in the following commands

1. Install all the dependencies.
   ```shell
    composer install
   ```
2. Generate the application keys
    ```shell
    php artisan key:generate
    ```
3. Create the tables and migrate them to your DB
    ```shell
    php artisan migrate
    ```
4. Populate the database with necessary system configuration
    ```shell
    php artisan db:seed`
    ```
    Yaay, you're done 👍
    
5. Now, Launch the development server.
   ```shell
   php artisan serve
   ```
6. Navigate to `http://localhost:8000` to view the website
7. Once you verify that the website is working, re-open the `.env` file to finish defining the remaining configurations

## Contributing

Contributions, issues, and feature requests are welcome!

Feel free to check the [issues page](../../issues)

  1. Fork the Project
  2. Create your Feature Branch (`git checkout -b feature/newFeature`)
  3. Commit your Changes (`git commit -m 'Add some newFeature'`)
  4. Push to the Branch (`git push -u origin feature/newFeature`)
  5. Open a Pull Request

## Configuration File

The `.env` file located in the root directory contains all the necessary configurations necessary for the application to run



## Authors

👤 *Dismus Ng'eno*

- GitHub: [@dismuskiplimo](https://github.com/dismuskiplimo)
- Twitter: [@dismus_kiplimo](https://twitter.com/dismus_kiplimo)
- LinkedIn: [Dismus Ng'eno](https://www.linkedin.com/in/dismus-kiplimo)

## Acknowledgements

* [Laravel Team](https://laravel.com/) for the amazing [Documentation](https://laravel.com/docs/master/introduction) on Laravel.
* [Safaricom Developer Team](https://developer.safaricom.co.ke/) for their in-depth [Documentation](https://ldeveloper.safaricom.co.ke) on the MPESA API.

## Show your support

Give a ⭐ if you like this project!
