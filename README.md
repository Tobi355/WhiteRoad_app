# WhiteRoad

Aplicación Laravel 12 para WhiteRoad. El código de Laravel está en `src/`; la configuración de Vercel permanece en la raíz del repositorio para que no haya que cambiar el directorio raíz del proyecto al importarlo.

## Despliegue en Vercel

La aplicación se ejecuta en el runtime de contenedores de Vercel con FrankenPHP. Este runtime está en beta y requiere Docker para probar la imagen localmente.

1. Importa el repositorio en Vercel desde la raíz, donde está `vercel.json`. El archivo enruta todas las solicitudes al servicio definido en `src/Dockerfile`; Caddy sirve los archivos estáticos desde `src/public` y Laravel procesa las rutas dinámicas.
2. Configura las variables de entorno de producción en **Vercel → Project Settings → Environment Variables**:
   - `APP_KEY`: clave nueva y estable, generada con `php artisan key:generate --show` desde `src/`.
   - `APP_URL`: URL HTTPS final del sitio.
   - `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` para una base MySQL externa y persistente (o `DB_URL` si tu proveedor proporciona una URL).
   - `MERCADOPAGO_ACCESS_TOKEN` y `MERCADOPAGO_PUBLIC_KEY` para la cuenta de producción.
   - Las variables `MAIL_*` si se habilita el envío de correo.
3. Ejecuta las migraciones contra esa base de datos antes de habilitar el sitio: `cd src` y `php artisan migrate --force`. No uses el SQLite local como base de producción.
4. Despliega con `vercel deploy --prod` desde la raíz del repositorio.

Las sesiones y la caché usan MySQL; la cola se ejecuta de forma síncrona porque una instancia web no mantiene workers de Laravel. Las imágenes estáticas de `src/public/storage` se incluyen en el repositorio. Los archivos escritos localmente por la aplicación dentro del contenedor no son persistentes; usa almacenamiento de objetos externo si en el futuro se agregan cargas de archivos.

**Importante:** no publiques secretos en Git. La plantilla `src/.env.example` no contiene claves. Si las credenciales que antes figuraban allí ya se usaron, revoca/rota el token de acceso de Mercado Pago y genera una nueva `APP_KEY`; configura los nuevos valores solo en Vercel.

Para desarrollo local, consulta [`src/README.md`](src/README.md).
