<?php
// api/contacto.php

// Mostrar errores solo para depuración
ini_set('display_errors', 0); 
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ajusta estas rutas según dónde esté tu carpeta PHPMailer dentro de /api
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Validar que la petición sea POST y sea una petición AJAX (Fetch)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recoger los datos enviados por el JavaScript
    $nombre = filter_var($_POST['nombre'] ?? '', FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var($_POST['mensaje'] ?? '', FILTER_SANITIZE_STRING);
    $csrf_token = $_POST['csrf_token'] ?? ''; // El JS genera este token

    // Validaciones básicas (que coinciden con las de tu JS)
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
        // 👇 REEMPLAZA ESTO CON TUS DATOS 👇
        $mail->Username   = 'munecodealambre@gmail.com'; 
        $mail->Password   = 'adavlzrxhbpyimwi'; 
        // 👆 REEMPLAZA ESTO CON TUS DATOS 👆
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Remitente y Destinatario
        $mail->setFrom($mail->Username, 'Portafolio - Nuevo Contacto'); 
        $mail->addAddress('ing.erickgustavocruz@gmail.com', 'Gustavo Cruz'); // Aquí llegará el mensaje
        $mail->addReplyTo($correo, $nombre); // Para responder directo al cliente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de tu Portafolio - ' . $nombre;
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
                <h2>Tienes un nuevo mensaje de contacto</h2>
                <hr>
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Correo:</strong> {$correo}</p>
                <p><strong>Mensaje:</strong></p>
                <div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #007BFF;'>
                    " . nl2br($mensaje) . "
                </div>
            </div>
        ";
        $mail->AltBody = "Nombre: {$nombre}\nCorreo: {$correo}\nMensaje:\n{$mensaje}";

        $mail->send();
        
        // Respuesta JSON que tu main.js está esperando
        echo json_encode(['success' => true, 'message' => '¡Mensaje enviado!']);
        
    } catch (Exception $e) {
        // Respuesta JSON de error que tu main.js está esperando
        echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje. Intenta más tarde.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>