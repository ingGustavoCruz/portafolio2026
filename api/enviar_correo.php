<?php
// api/enviar_correo.php

// Mostrar errores solo para depuración (quitar en producción)
ini_set('display_errors', 0); 
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ajusta estas rutas según dónde esté tu carpeta PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Validar que la petición sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitizar y recoger los datos
    $nombre = filter_var($_POST['nombre'] ?? '', FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var($_POST['mensaje'] ?? '', FILTER_SANITIZE_STRING);

    // Validar campos vacíos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos.']);
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'El formato del correo no es válido.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP (Ejemplo con Gmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'munecodealambre@gmail.com'; // <--- CAMBIA ESTO
        $mail->Password   = '22Alambr3$'; // <--- CAMBIA ESTO (Usa contraseñas de aplicación de Google)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y Destinatario
        $mail->setFrom($mail->Username, 'Portafolio Web'); // Quien lo envía (tu servidor)
        $mail->addAddress('ing.erickgustavocruz@gmail.com', 'Gustavo Cruz'); // A quién le llega (a ti)
        $mail->addReplyTo($correo, $nombre); // Para que al darle "Responder" le llegue al cliente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de tu Portafolio - ' . $nombre;
        $mail->Body    = "<h2>Nuevo mensaje de contacto</h2>
                        <p><strong>Nombre:</strong> {$nombre}</p>
                        <p><strong>Correo:</strong> {$correo}</p>
                        <p><strong>Mensaje:</strong><br>" . nl2br($mensaje) . "</p>";
        $mail->AltBody = "Nombre: {$nombre}\nCorreo: {$correo}\nMensaje:\n{$mensaje}";

        $mail->send();
        echo json_encode(['success' => true, 'message' => '¡Mensaje enviado correctamente!']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje. Intenta de nuevo. Mailer Error: {$mail->ErrorInfo}']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>