<?php
/**
 * api/db.example.php — Plantilla de configuración de BD
 * Portfolio — Ing. Gustavo Cruz
 *
 * ════════════════════════════════════════════════════════════════
 *  INSTRUCCIONES PARA CONFIGURAR TU ENTORNO:
 *
 *  1. Copia este archivo y renómbralo como: api/db.php
 *     cp api/db.example.php api/db.php
 *
 *  2. Rellena las constantes con tus credenciales reales de MySQL
 *     (las encuentras en cPanel → Bases de datos MySQL)
 *
 *  3. NUNCA subas api/db.php a GitHub.
 *     Está protegido en el .gitignore del proyecto.
 * ════════════════════════════════════════════════════════════════
 */

define('DB_HOST',    'localhost');         // Host — casi siempre es "localhost" en cPanel
define('DB_NAME',    'nombre_de_tu_bd');   // Nombre de la base de datos que creaste
define('DB_USER',    'tu_usuario_mysql');  // Usuario MySQL de cPanel
define('DB_PASS',    'tu_password_mysql'); // Contraseña del usuario MySQL
define('DB_PORT',    '3306');              // Puerto MySQL (3306 por defecto)
define('DB_CHARSET', 'utf8mb4');           // No cambiar

/**
 * Retorna una instancia PDO reutilizable (Singleton).
 *
 * @return PDO
 * @throws RuntimeException si la conexión falla
 */
function getDB(): PDO {
  static $pdo = null;

  if ($pdo === null) {
    $dsn = sprintf(
      'mysql:host=%s;port=%s;dbname=%s;charset=%s',
      DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
    );

    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
    ];

    try {
      $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
      error_log('[DB Error] ' . $e->getMessage());
      throw new RuntimeException('No se pudo conectar a la base de datos.', 500);
    }
  }

  return $pdo;
}