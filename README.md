
# Hotel Fénec

Este proyecto requiere la configuración de un archivo `.env` con las siguientes variables para funcionar adecuadamente:



## Configuración de la Aplicación

```dotenv
APP_NAME="Hotel Fenec"
APP_ENV=prod
APP_KEY=base64:jpP4D5dC9fzhN5yIL3tv7SPHN+QMQE4YPV8vKG9ZjVY=
APP_DEBUG=true
APP_URL= 
DEBUGBAR_ENABLE=true 
```

## reCAPTCHA

```dotenv
RECAPTCHA_V3_SITE_KEY=****
RECAPTCHA_V3_SECRET_KEY=**** 
```

## Stripe

```dotenv
STRIPE_KEY=****
STRIPE_SECRET=***
```
## Configuración de Logs

```dotenv
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

## Base de Datos (Recuerda que la tienes subida)

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel
DB_USERNAME=root
DB_PASSWORD=
```

## Drivers y Otros

```dotenv
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
MEMCACHED_HOST=127.0.0.1
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Configuración de Correo

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME="fenechotel@gmail.com"
MAIL_PASSWORD="rwpb ujes xdlq efkl"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="fenechotel@gmail.com"
MAIL_FROM_NAME='Hotel Fénec'
PHONE_NUMBER=957894502
ADDRESS="Calle San Martín S/N"
```


## Configuración AWS

```dotenv
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```


## Configuración Pusher

```dotenv
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
```

## Vite

```dotenv
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## Importante

 - Para que funcione el sistema de generar PDF's, es necesario instalar wkhtmlToPdf en la siguiente ruta: /usr/bin/wkhtmltopdf.
 - Debes rellenar las keys faltantes (***) con tus keys.
 - Recuerda realizar pagos con tarjetas ficticias, ya que está activado el modo desarrollador. Puedes encontrarlas en esta [web de Stripe](https://docs.stripe.com/testing?locale=es-ES).

