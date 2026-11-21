# Blog – Semana de Sistemas 2026

Aplicación web desarrollada con Laravel para la publicación y administración de noticias, actividades, talleres y eventos relacionados con la Semana de Sistemas 2026 de la Universidad de El Salvador.

## Tecnologías utilizadas

- PHP
- Laravel
- PostgreSQL
- JavaScript
- Vite
- HTML y CSS
- Docker

## Características principales

- Visualización pública de publicaciones.
- Administración de publicaciones.
- Gestión de categorías.
- Carga y administración de imágenes.
- Gestión de evidencias y archivos adjuntos.
- Panel administrativo.

## Estructura del proyecto

- `app/`: modelos, controladores y lógica de la aplicación.
- `database/`: migraciones, seeders y respaldos de la base de datos.
- `public/`: archivos públicos y recursos compilados.
- `resources/`: vistas y recursos del frontend.
- `routes/`: definición de rutas.
- `storage/`: almacenamiento de imágenes y archivos multimedia.

## Requisitos

- Docker y Docker Compose.
- PHP y Composer.
- Node.js y NPM.
- PostgreSQL.

El proyecto está preparado para integrarse en un entorno multiproyecto de Laravel con PostgreSQL compartido.

## Instalación y configuración

1. Clonar el repositorio o descomprimir el paquete de entrega.
2. Incorporar el proyecto al directorio de proyectos del entorno Laravel.
3. Configurar el archivo `.env` de acuerdo con el entorno local.
4. Instalar las dependencias de PHP:

   ```bash
   composer install
   ```

5. Instalar las dependencias del frontend:

   ```bash
   npm ci
   ```

6. Compilar los recursos:

   ```bash
   npm run build
   ```

## Base de datos

El paquete de entrega incluye un respaldo PostgreSQL ubicado en:

`database/backups/blog_sds_2026.sql`

Crear previamente la base de datos `blog_sds_2026` y restaurar el respaldo utilizando PostgreSQL.

La conexión debe configurarse en el archivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=blog_sds_2026
DB_USERNAME=postgres
DB_PASSWORD=tu_contraseña
```

Los valores deben adaptarse a la configuración del entorno donde se ejecute el proyecto.

## Almacenamiento de imágenes

Las imágenes de las publicaciones están incluidas en:

`storage/app/public/publications/`

Configurar el enlace simbólico de almacenamiento mediante:

```bash
php artisan storage:link
```

## Ejecución

Limpiar las cachés de configuración:

```bash
php artisan optimize:clear
```

Iniciar los servicios del entorno multiproyecto y acceder mediante el dominio local configurado.

## Entrega del proyecto

El paquete comprimido incluye:

- Código fuente de Laravel.
- Respaldo de la base de datos PostgreSQL.
- Imágenes y archivos multimedia.
- Recursos compilados del frontend.
- Archivos de configuración de dependencias.

**Repositorio:**  
https://github.com/JairoOrtiz06/Blog-SDS-2026

**Proyecto académico:** Semana de Sistemas 2026  
**Universidad de El Salvador**