# ChangeLog

Fichero donde se registran todos los cambios importantes que se hacen sobre el proyecto.

## [1.0.0]

### Añade
- Migración para la tabla `categories`.
- Migracion para la tabla `products`.
- Modelo `Category` para la migración `categories`.
- Controlador `CategoryController` para el modelo `Category`.
- Método `actualizaCategorias` que permite actualizar/importar los datos de categorias/subcategorias en `CategoryController`.
- Modelo `Product` para la migración `products`.
- Dependencia `guzzlehttp/guzzle` para hacer peticiones HTTP.
- Comando `app:actualizar-categorias` para importar/actualizar las categorias de la tabla `categories`.
- Controlador `ProductController` para el modelo `Product`.
- Método `actualizaProductos` que permite importar/actualizar los datos de los productos de diferentes categorias.
- Comando `app:actualizar-productos` para importar/actualizar los datos de diferentes productos de la tabla `products`.
- Tarea programada para ejecutar el comando `app:actualizar-categorias` cada 6 horas.
- Tarea programada para ejecutar el comando `app:actualizar-productos` cada 10 minutos.
- Dependencia `irazasyed/telegram-bot-sdk` para enviar notificaciones a Telegram.
- Sistema de notificación por Telegram cuando el precio de algún producto cambie.