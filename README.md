# Proyecto CodeIgniter 4.5 - Carga de Archivos a Amazon S3 y Administración de Usuarios

## Requisitos
- PHP 8.1 o superior
- Composer
- Extensión SQLite3 habilitada
- Cuenta de AWS con acceso a S3

## Instalación
### 1. Clonar el repositorio
```sh
 git clone https://github.com/osoluche/codeigniter-aws-s3.git
 cd codeigniter-aws-s3
```

### 2. Instalar dependencias con Composer
```sh
 composer install
```

### 3. Configurar el entorno
Duplicar el archivo `env.example` y renombrarlo a `.env`. Luego, configurar las siguientes variables de AWS:
```ini
aws.access_key_id=TU_ACCESS_KEY
aws.secret_access_key=TU_SECRET_KEY
aws.s3_bucket=TU_BUCKET_S3
```

### 4. Configurar la base de datos SQLite3
En el archivo `.env`, modificar la configuración de base de datos:
```ini
database.default.DBDriver=SQLite3
database.default.database=WRITEABLE/database.sqlite
```
Crear el archivo de la base de datos:
```sh
touch writable/database.sqlite
```

### 5. Ejecutar migraciones
```sh
php spark migrate
```

## Uso
### Iniciar el servidor de desarrollo
```sh
php spark serve
```
La aplicación estará disponible en `http://localhost:8080`

## Funcionalidades
- **Carga de archivos a Amazon S3** (crear, eliminar, copiar url)
- **Administración de usuarios** (registro, login, gestión de perfiles)

## Notas adicionales
- Asegúrese de configurar correctamente las credenciales de AWS.
- Puede modificar la configuración del sistema en el archivo `.env` según sus necesidades.

## Licencia
Este proyecto está bajo la licencia MIT.

