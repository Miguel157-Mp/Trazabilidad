<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $remitente = 'info@vidapetsoficial.com';
    $password = '1Nf0P3ets2023++';
    $nombrere = 'Vida Pets';
    $destinatario = 'perniapma.usm@gmail.com'; // Cambia esto según sea necesario
    $nombredes = 'Nombre del destinatario'; // Cambia esto según sea necesario
    $asunto = 'Nueva Solicitud';
    $mensaje = '<!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Vidapets</title>
        <style>
            .btn {
                display: inline-block;
                padding: 6px 12px;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                touch-action: manipulation;
                cursor: pointer;
                background-image: none;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            .btn-info {
                color: #fff;
                background-color: #17a2b8;
                border-color: #17a2b8;
            }
            .btn-secondary {
                color: #fff;
                background-color: #6c757d;
                border-color: #6c757d;
            }
        </style>
    </head>
    <body>
        <p>
            <img style="width: 850px;" src="https://vidapetsoficial.com/app/trazabilidad/dashboard/admin/img/bannerRecordatorio.jpg">
        </p>
        <hr>
        <small style="color:grey;">Este es un correo autom&aacute;tico y sin supervisi&oacute;n, por favor no responder ni realizar consultas. Para ello utilizar los canales regulares de contacto</small>
        
        <table style="border-collapse: collapse; width: 50%; margin: 0 auto;">
            <tbody>
                <tr>
                    <td style="border: 1px #e3e3e3 solid; padding: 10px 30px; text-align: left;">' . $mjs . '</td>
                </tr>
                <tr>
                    <td style="border: 1px #e3e3e3 solid; padding: 8px; text-align: center; color: grey;">
                        Hola <b>Administracion</b>.
                        <br><br>
                        Tiene una orden enviada por Servicios Generales.
                        <br><br>
                        <a style="color:#15c !important;" href="https://vidapetsoficial.com" target="_blank">Visita nuestra p&aacute;gina web</a>
                        <br>
                        <span>Copyright &copy; <a style="color:#15c !important;" href="https://vidapetsoficial.com" target="_blank">Vidapets</a></span> 2024 | Desarrollado por <a style="color:#15c !important;" href="https://www.instagram.com/sistemasabemar2020/" target="_blank">Sistemas AbeMar</a></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>';
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'k2s01.k2webhost.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $remitente;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Destinatarios
        $mail->setFrom($remitente, $nombrere);
        $mail->addAddress($destinatario, $nombredes);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;

        // Enviar correo
        if ($mail->send()) {
            echo json_encode(array('estatus' => 1, 'mjs' => 'Correo enviado'));
        } else {
            echo json_encode(array('estatus' => 2, 'mjs' => 'Error al enviar correo'));
        }
    } catch (Exception $e) {
        echo json_encode(array('estatus' => 2, 'mjs' => "Error: {$mail->ErrorInfo}"));
    }
}
?>