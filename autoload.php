<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarNotificaciones($cliente_nombre, $cliente_email, $detalles) {
    
    // 1. CARGAR TU CONFIGURACIÓN
    $config = require __DIR__ . '/config.php';
    $smtp_conf = $config['smtp'];

    $mail = new PHPMailer(true);

    try {
        // 2. PARCHE SSL PARA XAMPP (Sin esto, Outlook bloquea localhost)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // 3. CONFIGURAR PHPMAILER CON TUS DATOS DEL CONFIG
        $mail->isSMTP();
        $mail->Host       = $smtp_conf['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_conf['username'];
        $mail->Password   = $smtp_conf['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS = STARTTLS
        $mail->Port       = $smtp_conf['port'];
        $mail->CharSet    = 'UTF-8';

        // 4. REMITENTE Y DESTINATARIO
        $mail->setFrom($smtp_conf['from_email'], $smtp_conf['from_name']);
        
        // Correo al Admin (se envía a la misma cuenta configurada)
        $mail->addAddress($smtp_conf['username']); 

        $mail->isHTML(true);
        $mail->Subject = '🔔 Nueva Cotización: ' . $cliente_nombre;
        $mail->Body    = "
            <h2>Nueva Solicitud Recibida</h2>
            <p><strong>Cliente:</strong> $cliente_nombre ($cliente_email)</p>
            <p><strong>Fecha:</strong> {$detalles['fecha']}</p>
            <p><strong>Invitados:</strong> {$detalles['invitados']}</p>
            <p><strong>Notas:</strong> {$detalles['notas']}</p>
        ";
        $mail->send();

        // Correo al Cliente
        $mail->clearAddresses();
        $mail->addAddress($cliente_email);
        $mail->Subject = '✨ Confirmación - Enjoy Travel';
        $mail->Body    = "
            <div style='font-family: Arial; padding: 20px; background: #fff1f2;'>
                <h2 style='color: #be123c;'>¡Hola $cliente_nombre!</h2>
                <p>Hemos recibido tu solicitud para el <strong>{$detalles['fecha']}</strong>.</p>
                <p>Un asesor te contactará pronto.</p>
            </div>
        ";
        $mail->send();

        return true;

    } catch (Exception $e) {
        // En caso de error, descomenta la linea de abajo para ver qué pasa:
        // echo "Mailer Error: " . $mail->ErrorInfo; exit;
        return false;
    }
}
?>