<img src="https://raw.githubusercontent.com/ValentinoBorgo/Cineverse/cec23920ff829c0b602a0bd32a1796892bbf9fd7/public/c.svg" alt="" width="50px"> 

## Cineverse

This repository contains a project that is a web focused on viewing and interacting with multimedia titles such as movies, series and documentaries, made in PHP based on the Symfony framework.

## Features

- Filtering of desired title.
- Division into categories.
- Functionalities such as play a trailer, give mg, leave a review and pay for a premium package.

## Technologies used

- ![PHP](https://img.shields.io/badge/-PHP-333333?style=flat&logo=PHP)</br>
- ![Symfony](https://img.shields.io/badge/-Symfony-333333?style=flat&logo=Symfony)</br>

## Installation
1 - Clone the repository</br>
2 - In the project folder, run: composer install</br>
3 - Start a local server in XAMPP or Laragon</br>
4 - Create a database with the name: php bin/console doctrine:database:create --connection=default --if-not-exists cineverse</br>
5 - Link the database to the project in the .env file</br>
6 - Run the following command: php bin/console make:migration</br>
7 - Run the following command: php bin/console doctrine:migrations:migrate</br>
8 - Generate an APIKEY at https://www.themoviedb.org/ and place it in the ListadoTitulosManager.php file in the variable named $APIKEY</br>
9 - Generate a Youtube DATA API V3 APIKEY and place it in the TituloManager.php file in the variable named $APIKEY</br>
10 - In your preferred browser, enter the following address: http://localhost/cineverse/public/</br>

## Contributions

Contributions are always welcome. If you encounter any problems or have any suggestions, feel free to open an issue or send a pull request.

## Authors

Cozzi Osvaldo</br>
Borgo Valentino</br>
