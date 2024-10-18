PRUEBA TÉCNICA.

Método: Esta prueba técnica se envía para que el candidato la haga en casa con los medios que estime.
La entrega se hace mediante un enlace a un repositorio público de GitHub* en el que se aloje el
proyecto.
El enlace será adjuntado / enviado por correo electrónico en respuesta al mismo en el que se mandan
estas instrucciones.
*: ¡ATENCIÓN! Solo se admitirán enlaces a proyectos públicos alojados en GitHub.
Expectativa: Se espera que el candidato proponga una solución realizada en el framework Laravel con
PHP 8 o superior y con los estilos basados en Bootstrap 4. Debe usarse la plantilla AdminLTE 3 o
similares para la base del diseño. (Se debe usar el sistema de plantillas Blade).

---

Etapa I: Instalación y configuración de un nuevo proyecto de Laravel con el sistema de autenticación
por defecto de este framework (Inicio de Sesión y Registro) y base de datos MySQL / MariaDB.

Etapa II: Diseño de la interfaz de la aplicación con menú, cabecera y pie de página.

Etapa III: Realización de CRUD de usuarios para gestionar el acceso a la aplicación con campos como
“Nombre”, “Email”, etc. (Diseño a gusto del usuario, funcionalidad mediante AJAX).
Se debe incluir un campo seleccionable de “Administrador” que permitirá funciones extra más adelante.
Insertar acceso desde el menú.

Etapa IV: Desarrollo de un sistema de control de tareas de proyectos basado en los siguientes puntos
clave (Insertar también acceso desde el menú):
1.- Botón de añadir proyecto (No se contempla editar ni eliminar para esta prueba). Solo para
usuarios “Administradores”.
a. Se solicitará únicamente el nombre del proyecto mediante una ventana modal.
2.- Listado de proyectos ordenados por última fecha de uso con nombre del proyecto y usuario que
lo ha creado, cargado mediante AJAX (Al añadir un nuevo proyecto, la lista se debe recargar
automáticamente).
3.- Calendario al que se puedan arrastrar los proyectos para añadir información sobre su desarrollo
(tarea) en un tramo en concreto para cada usuario de la aplicación. Por defecto el usuario
seleccionado será en usuario que ha iniciado sesión.
Una vez guardada la información se deberá cargar mediante AJAX las tareas del usuario
seleccionado al calendario cada vez que se cambie de usuario o se entre a la página.
4.- Informe PDF de tareas agrupadas por proyectos con filtro de proyecto, fecha desde, fecha hasta
y usuario que realizó la tarea. Se debe mostrar el tiempo de cada tarea y el global asignado al
proyecto según los filtros.

Etapa V: Finalización de la prueba y presentación de la documentación.
