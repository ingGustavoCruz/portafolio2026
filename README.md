# Portafolio 2026 
# 🚀 Portfolio Web — Ing. Gustavo Cruz
**Desarrollador Web Full-Stack**

---

## 📁 Estructura del proyecto

```
ING_GUSTAVOCRUZ/
├── index.php                  ← Página principal (TODAS las secciones)
├── .htaccess                  ← Seguridad, caché y compresión Apache
├── README.md                  ← Este archivo
│
├── api/
│   ├── contacto.php           ← Endpoint POST del formulario de contacto
│   ├── db.php                 ← Conexión PDO a MySQL ⚠️ (editar credenciales)
│   └── database.sql           ← Script para crear la BD en phpMyAdmin
│
├── assets/
│   ├── css/
│   │   └── styles.css         ← Estilos principales
│   ├── js/
│   │   └── main.js            ← JavaScript (módulos vanilla)
│   ├── img/
│   │   ├── perfil.jpg         ← Tu foto profesional (recomendado: 500x500px WebP)
│   │   ├── og-preview.jpg     ← Imagen Open Graph (1200x630px)
│   │   ├── favicon.svg        ← Favicon SVG
│   │   ├── avatar-call.png    ← Avatar sección contacto
│   │   ├── avatar-gracias.png ← Avatar sección agradecimiento
│   │   ├── avatar-footer.png  ← Avatar footer
│   │   └── proyectos/
│   │       ├── proyecto1.jpg  ← Capturas de pantalla (600x380px WebP)
│   │       ├── proyecto2.jpg
│   │       └── ...
│   ├── videos/
│   │   ├── proyecto2.mp4      ← Videos locales (si no usas YouTube)
│   │   └── ...
│   └── docs/
│       └── CV_GustavoCruz.pdf ← Tu CV descargable
│
└── vendor/                    ← (Generado por Composer — NO subir a Git)
    └── autoload.php
```

---

## ⚙️ Instalación paso a paso

### 1. Subir archivos al hosting (cPanel)
- Comprime todos los archivos en un `.zip`
- Ve a cPanel → **Administrador de Archivos** → `public_html`
- Sube y descomprime

### 2. Crear la base de datos
1. cPanel → **phpMyAdmin**
2. Crear nueva base de datos: `portafolio_gc`
3. Importar `api/database.sql`

### 3. Configurar credenciales de BD
Abre `api/db.php` y edita:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portafolio_gc');
define('DB_USER', 'tu_usuario_cpanel');  // ← cPanel → Bases de datos MySQL
define('DB_PASS', 'tu_contraseña');
```

### 4. Instalar PHPMailer (SMTP)

**Opción A — Con Composer (recomendado):**
```bash
composer require phpmailer/phpmailer
```

**Opción B — Sin Composer:**
- Descarga PHPMailer: https://github.com/PHPMailer/PHPMailer/releases
- Descomprime en `vendor/phpmailer/phpmailer/`

### 5. Configurar SMTP en `api/contacto.php`
```php
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USER', 'tu.correo@gmail.com');
define('MAIL_PASS', 'xxxx xxxx xxxx xxxx');  // App Password de Google
define('MAIL_TO',   'ing.erickgustavocruz@gmail.com');
```

**Crear App Password de Gmail:**
1. Cuenta Google → Seguridad → Verificación en 2 pasos
2. Contraseñas de aplicaciones → Crear nueva
3. Copia la contraseña de 16 caracteres

### 6. Agregar tus imágenes y contenido
- `assets/img/perfil.jpg` — Tu foto (cuadrada, mín. 500×500px)
- `assets/img/proyectos/proyectoN.jpg` — Capturas de pantalla
- `assets/docs/CV_GustavoCruz.pdf` — Tu CV
- Edita el arreglo `$proyectos` en `index.php` con tus datos reales

### 7. Actualizar datos personales en `index.php`
Busca y reemplaza:
- `tuusuario` → tu usuario de GitHub
- `https://linkedin.com/in/tuusuario` → tu LinkedIn real
- `https://www.tudominio.com` → tu dominio

### 8. Habilitar HTTPS (muy recomendado)
En cPanel → **SSL/TLS** → Let's Encrypt (gratuito)
Luego descomenta estas líneas en `.htaccess`:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🎨 Personalización rápida

### Cambiar colores (CSS variables en `assets/css/styles.css`)
```css
:root {
  --color-blue: #007BFF;   /* Azul principal */
  --color-cyan: #00D4FF;   /* Cian acento */
  --color-navy: #041C38;   /* Azul oscuro */
}
```

### Agregar/quitar proyectos (`index.php`)
```php
$proyectos = [
  [
    'id'          => 9,
    'titulo'      => 'Mi Nuevo Proyecto',
    'descripcion' => 'Descripción del proyecto...',
    'imagen'      => 'assets/img/proyectos/proyecto9.jpg',
    'stack'       => ['PHP', 'MySQL', 'React'],
    'filtros'     => ['php', 'mysql', 'react'],
    'github'      => 'https://github.com/tuusuario/repo',
    'demo'        => 'https://tudominio.com/demo',
    'video'       => 'https://www.youtube.com/embed/TU_VIDEO_ID',
    'tipo_video'  => 'youtube',  // 'youtube' o 'local'
  ],
];
```

### Agregar tecnologías al carrusel (`index.php`)
```php
$tecnologias = [
  // ...
  ['nombre' => 'Vue.js', 'icono' => 'ri-vuejs-line', 'color' => '#4FC08D'],
];
```

---

## 🔒 Seguridad implementada

- ✅ Prepared statements PDO (anti SQL injection)
- ✅ `htmlspecialchars` en todos los outputs
- ✅ Validación doble (frontend JS + backend PHP)
- ✅ Rate limiting por sesión (1 mensaje/60 seg)
- ✅ Cabeceras HTTP de seguridad (CSP, XSS, MIME)
- ✅ Acceso directo a `/api/db.php` bloqueado por `.htaccess`
- ✅ Solo acepta peticiones AJAX (`X-Requested-With`)
- ✅ CSRF token básico en el formulario

---

## ⚡ Rendimiento

- ✅ CSS Mobile First sin framework pesado
- ✅ JS Vanilla (sin jQuery, sin React)
- ✅ Imágenes con `loading="lazy"` + Intersection Observer
- ✅ Fuentes Google con `preconnect` + `display=swap`
- ✅ Compresión GZIP vía `.htaccess`
- ✅ Cache-Control de 1 año para activos estáticos
- ✅ Carrusel con CSS animation (sin librería)

---

## 📱 Soporte de navegadores

| Navegador | Soporte |
|-----------|---------|
| Chrome 90+ | ✅ |
| Firefox 88+ | ✅ |
| Safari 14+ | ✅ |
| Edge 90+ | ✅ |
| Chrome Android | ✅ |
| Safari iOS 14+ | ✅ |

---

## 📞 Contacto y soporte

**Ing. Gustavo Cruz**
- 📧 ing.erickgustavocruz@gmail.com
- 🐙 github.com/ingGustavoCruz
- 💼 linkedin.com/in/ing-erick-gustavo-cruz-barrios-8730b752/

---

*Portfolio generado con PHP puro, CSS custom y JavaScript Vanilla. Sin frameworks pesados. Mobile first.*
