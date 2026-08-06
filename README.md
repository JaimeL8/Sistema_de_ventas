# Sistema de Ventas e Inventario (ERP)

Este es un sistema de gestión de ventas, productos, clientes y empleados desarrollado en Laravel. Incluye el consumo de la API del Banco de México (Banxico) para consultar el tipo de cambio en tiempo real.

## Requisitos Previos

Para poder ejecutar este proyecto localmente, necesitas tener instalado:
* [XAMPP](https://www.apachefriends.org/es/index.html) (con PHP 8.2 o superior y MySQL).
* [Composer](https://getcomposer.org/) (Gestor de dependencias de PHP).
* [Git](https://git-scm.com/)

## Instrucciones de Instalación e Inicialización

Sigue estos pasos cuidadosamente para levantar el proyecto en tu entorno local:


 1. Clonar el repositorio
Abre tu terminal y ejecuta el siguiente comando para descargar el proyecto:
```bash
 $ git clone https://github.com/JaimeL8/Sistema_de_ventas

2. Instalar las dependencias
Como la carpeta vendor no se sube a GitHub por su peso, debes instalar las librerías de Laravel ejecutando:

$ composer install

3. Configurar el archivo de entorno (.env)
El archivo .env contiene credenciales sensibles y no se incluye en el repositorio. Debes crear una copia del archivo de ejemplo:

Copia el archivo .env.example y renómbralo a .env.

(O ejecuta en consola: cp .env.example .env).

4. Generar la clave de la aplicación
Ejecuta el siguiente comando para generar la llave de seguridad de Laravel:

Bash
$ php artisan key:generate

5. Configurar la Base de Datos
Abre XAMPP e inicia los servicios de Apache y MySQL.

Entra a http://localhost/phpmyadmin y crea una base de datos vacía llamada sistema_ventas.

Abre el archivo .env de tu proyecto y asegúrate de que la conexión a la base de datos esté así:

Fragmento de código: 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_ventas
DB_USERNAME=root
DB_PASSWORD=

6. Configurar la API de Banxico
En el mismo archivo .env (o directamente en app/Http/Controllers/HomeController.php), asegúrate de colocar un token válido generado desde el portal de desarrolladores de Banxico para que el módulo del Home Page funcione correctamente.

7. Ejecutar las Migraciones
Para construir todas las tablas de la base de datos (clientes, empleados, productos, ventas y detalles), ejecuta:

$ php artisan migrate

8. Iniciar el Servidor Local
Finalmente, levanta el servidor de desarrollo de Laravel con:

$ php artisan serve

Abre tu navegador y visita: http://127.0.0.1:8000


