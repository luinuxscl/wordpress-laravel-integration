# Wordpress Laravel Integration

## 📌 Introducción
Este package permite integrar una aplicación Laravel con un sitio WordPress, facilitando la administración de posts, categorías, etiquetas y medios a través de la API REST de WordPress.

## 🚀 Instalación

Puedes instalar este package usando Composer:

```bash
composer require luinuxscl/wordpress-laravel-integration
```

Si deseas publicar las configuraciones y vistas del package en tu aplicación Laravel, ejecuta:

```bash
php artisan vendor:publish --tag=wordpress-config
php artisan vendor:publish --tag=wordpress-views
```

## 📄 Configuración

Después de instalar el package, asegúrate de configurar las credenciales en la base de datos. Puedes usar el siguiente comando para ejecutar las migraciones:

```bash
php artisan migrate
```

## 🔧 Uso del Package

### ✅ **Usando el Facade**
Puedes interactuar con la API de WordPress de manera sencilla usando la **Facade `WordpressIntegration`**:

```php
use Luinuxscl\WordpressIntegration\Facades\WordpressIntegration;

// Crear un nuevo post en WordPress
$response = WordpressIntegration::createPost([
    'title' => 'Mi Nuevo Post',
    'content' => 'Contenido del post generado desde Laravel.',
]);
```

### ✅ **Uso con el Service Container**
Si prefieres la inyección de dependencias, puedes utilizar el servicio directamente:

```php
use Luinuxscl\WordpressIntegration\Services\WordpressService;

$wordpressService = app(WordpressService::class);
$wordpressService->createPost([
    'title' => 'Título del Post',
    'content' => 'Contenido del post en WordPress.',
]);
```

## 🌍 Rutas Disponibles
Este package expone las siguientes rutas:

| Método  | Ruta                   | Acción                           |
|---------|------------------------|---------------------------------|
| `POST`  | `/wordpress/posts`      | Crear un nuevo post en WordPress |
| `GET`   | `/wordpress/posts/{id}` | Obtener un post específico      |

Ejemplo de uso con AJAX:
```javascript
fetch('/wordpress/posts', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        title: 'Post desde JS',
        content: 'Contenido enviado desde JavaScript.',
    }),
}).then(response => response.json()).then(data => console.log(data));
```

## ✅ Uso del Componente Livewire
Este package incluye un componente Livewire para gestionar credenciales de WordPress de manera interactiva.

### 📌 **Cómo usarlo**
1. Asegúrate de que **Livewire** está instalado en tu proyecto:
   ```bash
   composer require livewire/livewire
   ```
2. Usa el componente en cualquier vista Blade:
   ```blade
   <livewire:wordpress-credentials-form />
   ```
3. El componente mostrará un formulario interactivo para agregar credenciales de WordPress.

## ✅ Pruebas
Este package incluye pruebas con PHPUnit y Orchestra Testbench. Para ejecutarlas, usa:

```bash
vendor/bin/phpunit
```

## 🎯 Contribuciones
Si deseas mejorar este package, envía un Pull Request en [GitHub](https://github.com/luinuxscl/wordpress-laravel-integration).

## 📄 Licencia
Este package está disponible bajo la licencia **MIT**.