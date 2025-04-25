#!/bin/sh
# Detiene la ejecución si algún comando falla
set -e

# Variables de entorno para la conexión a la BD (ya definidas en docker-compose)
host="$DB_HOST"
port="$DB_PORT"
user="$DB_USERNAME" # No es estrictamente necesario para el wait, pero útil para debug
db_name="$DB_DATABASE" # No es estrictamente necesario para el wait, pero útil para debug

echo "Entrypoint script started..."
echo "Waiting for database at $host:$port..."

# Esperar a que el puerto de la base de datos esté abierto
# Usamos netcat (nc) para verificar la conexión TCP
# Necesitarás instalar netcat en tu Dockerfile
while ! nc -z $host $port; do
  echo "Database ($host:$port) is unavailable - sleeping"
  sleep 1
done

echo "Database is up and running!"

# Ejecutar las migraciones de Laravel
# El flag --force es importante porque el comando se ejecuta de forma no interactiva
echo "Running database migrations..."
php artisan migrate --force
php artisan db:seed --force

echo "Migrations finished."

# Ejecutar el comando original del contenedor (iniciar Apache)
# "$@" pasa cualquier argumento que se haya pasado al entrypoint (o el CMD del Dockerfile)
echo "Executing container's default command..."
exec "$@"