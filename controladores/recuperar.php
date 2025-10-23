<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';

include "../config/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email'])) {
    $email = trim($_POST['email']);

    
    $query = "SELECT id, nombre, email, contrasena 
              FROM usuarios 
              WHERE email = ? 
              LIMIT 1";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
         
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'laugamer334@gmail.com';
                $mail->Password   = 'omat qkjm nbso womu';   
                $mail->Port       = 587;

                $mail->setFrom('laugamer334@gmail.com', 'Ticketify - Recuperar Contraseña');
                $mail->addAddress($email, $row['nombre']);

                
                $link = "http://localhost/modulo2/vista/nueva_contraseña.php?id=" . urlencode($row['id']);

                
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de contraseña - Ticketify';
                $mail->Body = "
                    <div style='font-family:Arial, sans-serif;'>
                        <h2>Hola, " . htmlspecialchars($row['nombre']) . "</h2>
                        <p>Has solicitado recuperar tu contraseña en <strong>Ticketify</strong>.</p>
                        <p>Haz clic en el siguiente enlace para restablecerla:</p>
                        <p><a href='" . $link . "' style='display:inline-block;background-color:#007bff;color:white;padding:10px 15px;border-radius:5px;text-decoration:none;'>Recuperar contraseña</a></p>
                        <p>Si no solicitaste esto, puedes ignorar este mensaje.</p>
                        <br>
                        <p>Atentamente,<br><strong>Equipo Ticketify</strong></p>
                    </div>
                ";

                
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true
                    ]
                ];

                $mail->send();

                header("Location: ../vista/login.php?message=Revisa tu correo para restablecer tu contraseña");
                exit;
            } catch (Exception $e) {
                
                error_log("Error al enviar correo: {$mail->ErrorInfo}");
                header("Location: ../vista/login.php?message=error");
                exit;
            }
        } else {
            header("Location: ../vista/login.php?message=not_found");
            exit;
        }
    } else {
        error_log("Error en la preparación de la consulta: " . $conexion->error);
        header("Location: ../vista/login.php?message=error");
        exit;
    }
}
?>


