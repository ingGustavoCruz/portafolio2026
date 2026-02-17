<?php
/**
 * api/contacto.php — Endpoint POST para formulario de contacto
 * Portfolio — Ing. Gustavo Cruz
 *
 * Acciones:
 *  1. Valida la solicitud (método, headers, CSRF básico)
 *  2. Sanitiza y valida los datos del formulario
 *  3. Guarda el mensaje en la base de datos MySQL
 *  4. Envía correo de notificación con PHPMailer (SMTP)
 *  5. Responde JSON { success: bool, message: string }
 *
 * Dependencias:
 *  - PHPMailer (instala con: composer require phpmailer/phpmailer)
 *  - api/db.php (conexión PDO)
 */

declare(strict_types=1);

/* ── Cabeceras de seguridad y tipo de respuesta ── */
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

/* ── Solo aceptar POST con XMLHttpRequest ── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
  exit;
}

if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') {
  http_response_code(403);
  echo json_encode(['success' => false, 'message' => 'Acceso no permitido.']);
  exit;
}

/* ── Rate limiting simple con sesión ── */
session_start();
$now = time();
$key = 'gc_contact_last';
if (isset($_SESSION[$key]) && ($now - $_SESSION[$key]) < 60) {
  http_response_code(429);
  echo json_encode(['success' => false, 'message' => 'Por favor espera un momento antes de enviar otro mensaje.']);
  exit;
}

/* ── Cargar conexión BD ── */
require_once __DIR__ . '/db.php';

/* ══════════════════════════════════════════════
   CONFIGURACIÓN — SMTP / CORREO
   Actualiza con tus datos antes de producción
══════════════════════════════════════════════ */
define('MAIL_HOST',       'smtp.gmail.com');       // SMTP server
define('MAIL_PORT',       587);                     // Puerto: 587 (TLS) | 465 (SSL)
define('MAIL_USER',       'tu.correo@gmail.com');  // Tu correo Gmail
define('MAIL_PASS',       'tu_app_password');       // App Password de Gmail (no tu contraseña)
define('MAIL_FROM_NAME',  'Ing. Gustavo Cruz — Portfolio');
define('MAIL_TO',         'ing.erickgustavocruz@gmail.com'); // A dónde llegan los mensajes
define('MAIL_TO_NAME',    'Ing. Gustavo Cruz');

/* ══════════════════════════════════════════════
   FUNCIONES DE UTILIDAD
══════════════════════════════════════════════ */

/**
 * Sanitiza y valida un campo de texto
 */
function sanitize(string $value, int $min, int $max): string|false {
  $clean = trim(htmlspecialchars(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
  $len   = mb_strlen($clean);
  if ($len < $min || $len > $max) return false;
  return $clean;
}

/**
 * Crea la tabla de contactos si no existe
 */
function ensureTable(PDO $db): void {
  $db->exec("
    CREATE TABLE IF NOT EXISTS `contactos` (
      `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `nombre`     VARCHAR(100) NOT NULL,
      `correo`     VARCHAR(150) NOT NULL,
      `mensaje`    TEXT         NOT NULL,
      `ip`         VARCHAR(45)  DEFAULT NULL COMMENT 'IPv4 o IPv6',
      `user_agent` VARCHAR(300) DEFAULT NULL,
      `leido`      TINYINT(1)   NOT NULL DEFAULT 0,
      `creado_en`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      INDEX `idx_correo` (`correo`),
      INDEX `idx_leido`  (`leido`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  ");
}

/**
 * Guarda el contacto en la BD con prepared statement
 */
function saveContact(PDO $db, string $nombre, string $correo, string $mensaje, string $ip, string $ua): int {
  $stmt = $db->prepare("
    INSERT INTO `contactos` (`nombre`, `correo`, `mensaje`, `ip`, `user_agent`)
    VALUES (:nombre, :correo, :mensaje, :ip, :ua)
  ");
  $stmt->execute([
    ':nombre'  => $nombre,
    ':correo'  => $correo,
    ':mensaje' => $mensaje,
    ':ip'      => $ip,
    ':ua'      => mb_substr($ua, 0, 300),
  ]);
  return (int) $db->lastInsertId();
}

/**
 * Envía el correo de notificación usando PHPMailer
 *
 * NOTA: Si aún no instalas PHPMailer con Composer, puedes cambiar
 * esta función para usar mail() nativo temporalmente.
 */
function sendMail(string $nombre, string $correo, string $mensaje, int $id): bool {
  // Verificar si PHPMailer está disponible (Composer autoload)
  $autoload = __DIR__ . '/../vendor/autoload.php';
  if (!file_exists($autoload)) {
    // Fallback: mail() nativo
    $subject = "Nuevo contacto desde tu portafolio — #{$id}";
    $body    = "Nombre: {$nombre}\nCorreo: {$correo}\nMensaje:\n{$mensaje}";
    $headers = "From: portfolio@" . ($_SERVER['HTTP_HOST'] ?? 'tudominio.com') . "\r\n"
             . "Reply-To: {$correo}\r\n"
             . "X-Mailer: PHP/" . PHP_VERSION;
    return mail(MAIL_TO, $subject, $body, $headers);
  }

  require_once $autoload;

  use PHPMailer\PHPMailer;
  use PHPMailer\SMTP;
  use PHPMailer\Exception;

  $mail = new PHPMailer(true);
  try {
    // Servidor SMTP
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USER;
    $mail->Password   = MAIL_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = MAIL_PORT;
    $mail->CharSet    = 'UTF-8';

    // Remitente y destinatario
    $mail->setFrom(MAIL_USER, MAIL_FROM_NAME);
    $mail->addAddress(MAIL_TO, MAIL_TO_NAME);
    $mail->addReplyTo($correo, $nombre);

    // Contenido HTML del correo
    $mail->isHTML(true);
    $mail->Subject = "📬 Nuevo mensaje de contacto — Portfolio #{$id}";
    $mail->Body    = buildEmailHTML($nombre, $correo, $mensaje, $id);
    $mail->AltBody = "Nombre: {$nombre}\nCorreo: {$correo}\nMensaje:\n{$mensaje}";

    $mail->send();
    return true;
  } catch (Exception $e) {
    error_log("[Mailer Error #{$id}] " . $mail->ErrorInfo);
    return false;
  }
}

/**
 * Genera el HTML del correo de notificación
 */
function buildEmailHTML(string $nombre, string $correo, string $mensaje, int $id): string {
  $fecha = date('d/m/Y H:i:s');
  $msg   = nl2br(htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'));
  return <<<HTML
  <!DOCTYPE html>
  <html lang="es">
  <head><meta charset="UTF-8" /><meta name="viewport" content="width=device-width,initial-scale=1.0" /></head>
  <body style="margin:0;padding:0;background:#f4f7fb;font-family:'DM Sans',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
      <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
          <!-- Header -->
          <tr><td style="background:linear-gradient(135deg,#007BFF,#00D4FF);padding:32px 40px;text-align:center;">
            <h1 style="margin:0;color:#fff;font-size:1.4rem;font-weight:800;">&lt;/&gt; Ing. Gustavo Cruz</h1>
            <p style="margin:4px 0 0;color:rgba(255,255,255,0.85);font-size:0.85rem;">Nuevo mensaje de contacto desde tu portafolio</p>
          </td></tr>
          <!-- Cuerpo -->
          <tr><td style="padding:36px 40px;">
            <p style="margin:0 0 24px;font-size:0.85rem;color:#7a8aab;">Mensaje #{$id} recibido el {$fecha}</p>
            <!-- Datos del contacto -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="padding:12px 16px;background:#f4f7fb;border-radius:8px 8px 0 0;border-bottom:1px solid #e2e8f0;">
                  <p style="margin:0;font-size:0.75rem;color:#7a8aab;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Nombre</p>
                  <p style="margin:4px 0 0;font-size:1rem;color:#010814;font-weight:600;">{$nombre}</p>
                </td>
              </tr>
              <tr>
                <td style="padding:12px 16px;background:#f4f7fb;border-radius:0 0 8px 8px;">
                  <p style="margin:0;font-size:0.75rem;color:#7a8aab;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Correo electrónico</p>
                  <p style="margin:4px 0 0;font-size:1rem;"><a href="mailto:{$correo}" style="color:#007BFF;font-weight:600;">{$correo}</a></p>
                </td>
              </tr>
            </table>
            <!-- Mensaje -->
            <div style="background:#f4f7fb;border-left:4px solid #007BFF;border-radius:0 8px 8px 0;padding:16px 20px;">
              <p style="margin:0 0 8px;font-size:0.75rem;color:#7a8aab;text-transform:uppercase;letter-spacing:.08em;font-weight:600;">Mensaje</p>
              <p style="margin:0;font-size:0.95rem;color:#3a4a6b;line-height:1.7;">{$msg}</p>
            </div>
          </td></tr>
          <!-- Footer del correo -->
          <tr><td style="padding:20px 40px;background:#f4f7fb;border-top:1px solid #e2e8f0;text-align:center;">
            <p style="margin:0;font-size:0.78rem;color:#7a8aab;">Este mensaje fue enviado desde el formulario de contacto de tu portafolio web.</p>
          </td></tr>
        </table>
      </td></tr>
    </table>
  </body>
  </html>
HTML;
}

/* ══════════════════════════════════════════════
   LÓGICA PRINCIPAL
══════════════════════════════════════════════ */
try {
  /* 1. Obtener y sanitizar datos */
  $nombre  = sanitize((string) ($_POST['nombre']  ?? ''), 2, 100);
  $correo  = filter_input(INPUT_POST, 'correo',  FILTER_SANITIZE_EMAIL);
  $mensaje = sanitize((string) ($_POST['mensaje'] ?? ''), 10, 1000);

  /* 2. Validaciones */
  $errors = [];

  if ($nombre === false) {
    $errors[] = 'El nombre debe tener entre 2 y 100 caracteres.';
  }
  if (!$correo || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'El correo electrónico no es válido.';
  }
  if ($mensaje === false) {
    $errors[] = 'El mensaje debe tener entre 10 y 1000 caracteres.';
  }

  if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
  }

  /* 3. Guardar en BD */
  $db   = getDB();
  ensureTable($db);

  $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

  $insertId = saveContact($db, $nombre, $correo, $mensaje, $ip, $ua);

  /* 4. Enviar correo (no bloquear si falla) */
  $mailSent = sendMail($nombre, $correo, $mensaje, $insertId);
  if (!$mailSent) {
    error_log("[Contacto #{$insertId}] Guardado en BD pero el correo falló.");
  }

  /* 5. Registrar el timestamp para rate limiting */
  $_SESSION[$key] = $now;

  /* 6. Respuesta exitosa */
  http_response_code(200);
  echo json_encode([
    'success' => true,
    'message' => '¡Mensaje recibido! Me pondré en contacto contigo muy pronto.',
    'id'      => $insertId,
  ]);

} catch (RuntimeException $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Throwable $e) {
  error_log('[Contacto Error] ' . $e->getMessage());
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => 'Error interno del servidor. Intenta más tarde.']);
}