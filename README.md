# M.07 - UF4 - Histórico precios de Mercadona

## Descripción
Repositorio que permite llevar un seguimiento en los cambios de precio que haya sobre los productos de Mercadona.

Incorpora un sistema de notificaciones vía Telegram para mantenerte informado de todos los cambios, indicando el precio en el que se encontraba guardado en BD y el actual.

## Implementación

### 1. Clonar el repositorio

```bash
git clone https://github.com/CristianManuelAlcobendasBeorlegui/historico-precios-mercadona
```

### 2. Crear una copia del fichero '.env.example' y llamarla '.env'.

```bash
cp .env.example .env
```

### 3. Configurar las variables de entorno de Telegram

Para poder usar el sistema de notificación de Telegram se debe dar un valor a las siguientes variables de entorno:

- `TELEGRAM_BOT_NAME`: El nombre del bot.
- `TELEGRAM_BOT_TOKEN`: Código que dá el Bot `@BotFather` cuando creas al bot.
- `TELEGRAM_CHANNEL_ID`: El ID del grupo.

> Si tienes dudas sobre como conseguir estos datos, puedes acceder a las siguientes páginas
> 
> **_Luisramirez.dev - Cómo enviar mensajes a Telegram desde Laravel_**
> 
> **URL:** [https://luisramirez.dev/enviar-mensajes-a-telegram-desde-laravel/](https://luisramirez.dev/enviar-mensajes-a-telegram-desde-laravel/)
> 
> **_Github/Mraaroncruz - Conseguir el ID del grupo de Telegram_**
> 
> **URL:** [https://gist.github.com/mraaroncruz/e76d19f7d61d59419002db54030ebe35](https://gist.github.com/mraaroncruz/e76d19f7d61d59419002db54030ebe35)

### 4. Descargar e instalar dependencias

```bash
composer update 
composer install
```

### 5. Ejecutar las migraciones

```bash
php artisan migrate:refresh
```

### 6. Importar manualmente las primeras categorias y productos

Si queremos guardar productos, lo primero que necesitamos saber son las categorias disponibles.

Para importarlas por primera vez habrá que ejecutar el comando:

```bash
php artisan app:actualizar-categorias
```

Por último, para importar algunos productos podemos ejecutar el comando:

```bash
php artisan app:actualizar-productos
```

> **NOTA:** Ejecutamos los comandos para tener datos con los que poder tratar en BD. Los datos de categorias se pueden encontrar en la tabla `categories` y los productos en `products`.
>
> Además, ambos están programados para que se ejecuten en tareas programadas.
>
> - `app:actualizar-categorias`: Cada 6 horas.
> - `app:actualizar-productos`: Cada 10 minutos.