
# PRUEBA TÉCNICA

## Descripción del Proyecto

El proyecto se ha realizado en el IDE de Visual Studio Code, utilizando Wampserver con Apache 2.4.59, PHP 8.2.18 y PhpMyAdmin 5.2.1.

Para el proyecto se ha utilizado el framework de Laravel así como MySQL para la base de datos y para la interfaz del proyecto se ha hecho uso de la plantilla de AdminLTE, además de Bootstrap y CSS. Otra opción sería utilizar Sass y Tailwind para organizar los estilos en variables y funciones.

### Instalación de Dependencias

Para cargar las dependencias de Node.js y PHP, utilice los siguientes comandos:

#### Node.js
```sh
npm install
```
Este comando instalará todos los paquetes listados en el archivo `package.json` y creará la carpeta `node_modules`.

#### PHP
```sh
composer install
```
Este comando instalará todas las dependencias de PHP listadas en el archivo `composer.json` y creará la carpeta `vendor`.

### Ejecución del Proyecto

Para ejecutar el proyecto en local utilice el comando:
```sh
npm run dev
```
Este comando actualizará todos los cambios realizados en código para que se vean reflejados en la aplicación.

Para compilar el código fuente del proyecto en un formato que pueda ser desplegado en producción, utilice:
```sh
npm run build
```

### Migración de la Base de Datos

Para la migración de la base de datos, utilice el comando:
```sh
php artisan migrate
```
Este comando ejecutará todas las migraciones pendientes, creando las tablas necesarias en la base de datos según las definiciones en los archivos de migración.

Para cargar las tablas y datos predeterminados creados en las factories y seeders, utilice:
```sh
php artisan migrate:refresh --seed
```

## Imágenes

### Imágenes Relevantes del Proyecto

A continuación, se presentan algunas imágenes que ilustran las diferentes interfaces del proyecto:

![Interfaz de inicio](/public/img/Inicio.png)

![Interfaz de proyectos y calendario de tareas](/public/img/Proyectos.png)

![Interfaz de usuarios](/public/img/Usuarios.png)

---

## Instrucciones

### Método

Esta prueba técnica se envía para que el candidato la realice en casa con los medios que estime. La entrega se hace mediante un enlace a un repositorio público de GitHub* en el que se aloje el proyecto. El enlace será adjuntado/enviado por correo electrónico en respuesta al mismo en el que se mandan estas instrucciones.

> **Nota:** ¡ATENCIÓN! Solo se admitirán enlaces a proyectos públicos alojados en GitHub.

### Expectativas

Se espera que el candidato proponga una solución realizada en el framework Laravel con PHP 8 o superior y con los estilos basados en Bootstrap 4. Debe usarse la plantilla AdminLTE 3 o similares para la base del diseño. (Se debe usar el sistema de plantillas Blade).

---

## Etapas del Proyecto

### Etapa I: Instalación y Configuración

- Instalación y configuración de un nuevo proyecto de Laravel con el sistema de autenticación por defecto de este framework (Inicio de Sesión y Registro) y base de datos MySQL / MariaDB.

### Etapa II: Diseño de la Interfaz

- Diseño de la interfaz de la aplicación con menú, cabecera y pie de página.

### Etapa III: CRUD de Usuarios

- Realización de CRUD de usuarios para gestionar el acceso a la aplicación con campos como “Nombre”, “Email”, etc. (Diseño a gusto del usuario, funcionalidad mediante AJAX).
- Incluir un campo seleccionable de “Administrador” que permitirá funciones extra más adelante.
- Insertar acceso desde el menú.

### Etapa IV: Sistema de Control de Tareas

Desarrollo de un sistema de control de tareas de proyectos basado en los siguientes puntos clave (Insertar también acceso desde el menú):

1. **Añadir Proyecto**: Botón de añadir proyecto (No se contempla editar ni eliminar para esta prueba). Solo para usuarios “Administradores”.
    - Se solicitará únicamente el nombre del proyecto mediante una ventana modal.
2. **Listado de Proyectos**: Listado de proyectos ordenados por última fecha de uso con nombre del proyecto y usuario que lo ha creado, cargado mediante AJAX (Al añadir un nuevo proyecto, la lista se debe recargar automáticamente).
3. **Calendario**: Calendario al que se puedan arrastrar los proyectos para añadir información sobre su desarrollo (tarea) en un tramo en concreto para cada usuario de la aplicación. Por defecto el usuario seleccionado será el usuario que ha iniciado sesión.
    - Una vez guardada la información, se deberá cargar mediante AJAX las tareas del usuario seleccionado al calendario cada vez que se cambie de usuario o se entre a la página.
4. **Informe PDF**: Informe PDF de tareas agrupadas por proyectos con filtro de proyecto, fecha desde, fecha hasta y usuario que realizó la tarea. Se debe mostrar el tiempo de cada tarea y el global asignado al proyecto según los filtros.

### Etapa V: Finalización

- Finalización de la prueba y presentación de la documentación.




