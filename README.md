<img src="https://raw.githubusercontent.com/ValentinoBorgo/Cineverse/cec23920ff829c0b602a0bd32a1796892bbf9fd7/public/c.svg" alt="" width="50px"> ## Cineverse

Este repositorio contiene un proyecto dirigido a una materia de la tecnicatura que estoy cursando, este se trata de una web enfocada en visualizar e interactuar con titulos multimedia como peliculas, series y documentales, realizada en PHP basandonos en el framework Symfony.

## Características

- Filtrado de titulo deseado.
- Division en categorias.
- Funcionalidades tales como reproducir un trailer, dar mg, dejar una reseña y abonar un paquete premiun.

## Tecnologías utilizadas

- ![PHP](https://img.shields.io/badge/-PHP-333333?style=flat&logo=PHP)</br>
- ![Symfony](https://img.shields.io/badge/-Symfony-333333?style=flat&logo=Symfony)</br>

## Instalación
1 - Clonar el repositorio</br>
2 - Ejecutar en la carpeta del proyecto : composer install</br>
3 - Levantar un servidor local en XAMPP o Laragon</br>
4 - Crear una base de datos con el nombre : php bin/console doctrine:database:create --connection=default --if-not-exists cineverse</br>
5 - Asociar la bd al proyecto en el archivo .env</br>
6 - Ejecutar el siguiente comando : php bin/console make:migration</br>
7 - Ejecutar el siguiente comando : php bin/console doctrine:migrations:migrate</br>
8 - Generar una APIKEY en  https://www.themoviedb.org/ y colocarla en el archivo ListadoTitulosManager.php la variable con nombre $APIKEY</br>
9 - Generar una APIKEY de Youtube DATA API V3 y colocarla en el archivo TituloManager.php la variable con nombre $APIKEY</br>
10 - En el navegador de su preferencia intoducir la siguiente direccion : http://localhost/cineverse/public/</br>

## Contribuciones

Las contribuciones son siempre bienvenidas. Si encuentras algún problema o tienes alguna sugerencia, no dudes en abrir un issue o enviar un pull request.

## Autores

Cozzi Osvaldo</br>
Borgo Valentino</br>
