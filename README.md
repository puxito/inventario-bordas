# Inventario de Equipos

Este proyecto es un sistema de inventario de equipos desarrollado en PHP y MySQL con contenedores Docker. Incluye funcionalidades para realizar un CRUD (Crear, Leer, Actualizar, Borrar) de equipos, así como la visualización de detalles y la exportación de datos a PDF.

## Estructura del Proyecto

Este proyecto está compuesto por tres servicios definidos en el archivo `docker-compose.yml`:

1. **app**: Servicio PHP, donde se ejecuta tu aplicación.
2. **webserver**: Servicio Nginx, que sirve la aplicación PHP.
3. **db**: Servicio MySQL, que proporciona la base de datos.

## Archivos Importantes

- **docker-compose.yml**: Define la configuración de los servicios.
- **nginx.conf**: Configuración de Nginx.
- **php/Dockerfile**: Dockerfile para construir el contenedor de PHP.
- **src/**: El código fuente de la aplicación PHP.

## Configuración del Entorno

### Iniciar los Contenedores

Para iniciar todos los servicios, ejecuta:

```bash
docker-compose up -d
