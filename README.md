# La Vecindad del Chavo

Aplicación Laravel SPA (Vue.js) que muestra y administra los inquilinos de la vecindad del Chavo.


## Instalación

### Requisitos

- Requisitos de Laravel 5.7
- Composer
- Node 8+
- Yarn (o npm)

### Instrucciones

0. Clonar repositorio
0. Instalar dependencias:
  - `composer install`
  - `yarn`
0. Inicializar backend:
  - `composer initialize`
0. Preparar base de datos:
  - Crear base de datos
  - Configurar el archivo `.env` con las credenciales pertinentes
  - Inicializar tabla y datos predeterminados:
    - `php artisan migrate --seed`
0. [opcional] Configurar credenciales (Predeterminado: **`admin@example.com`** : **`admin`**):
  - Personalizar los valores de `DEFAULT_USER_*` en el archivo `.env`
- Run `yarn dev` or `yarn production`
0. Compilar frontend:
  - `yarn dev` o `yarn production`
0. Configurar servidor
  - Crear host virtual con Apache u otro, o simplemente usar el servidor predeterminado: `php artisan serve`
  - Nota: El servidor debe tener permisos de escritura en la carpeta `public/` para subir archivos, así como también `storage/` y demás usadas por Laravel
0. Entrar a la URL configurada en el navegador web
