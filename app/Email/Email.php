<?php

namespace App\Email;

use PHPMailer\PHPMailer\{PHPMailer, Exception, SMTP};

class Email
{
    private $SMTP_CONFIG;
    public $EMAIL_USER_CONTACT;

    function __construct()
    {
        $this->SMTP_CONFIG = array(
            'Host' => "mx72.hostgator.mx",
            'PORT' => 465,
            'Username' => 'webmaster@snsanfrancisco.com',
            'Password' => 'onyK!1bL(VWi',
            'name' => 'ESCOLAR - SystemName',
            'mailTest' => 'leonardovazquez81@gmail.com',

        );
        $this->EMAIL_USER_CONTACT = array(
            'name' => 'Leonardo',
            'lastname' => 'Vázquez Angulo',
            'email' => 'leonardovazquez81@gmail.com',
            'Subject' => 'Title test',
            'message' => 'Message test',
        );
    }
    function sendMail($USUARIO = false, $bodyMessage = "empty")
    {
        $config = $this->SMTP_CONFIG;
        $USUARIO = ($USUARIO) ? $USUARIO : $this->EMAIL_USER_CONTACT;
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
            //  $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

            $mail->CharSet = 'UTF-8';
            $mail->Debugoutput = 'html';

            $mail->Host = $config['Host'];
            $mail->Port = 465; //465 or 587
            $mail->IsHTML(true);
            /**
             * CONFIGURACIÓN CUENTA QUE ENVIA
             */
            $mail->Username = $config['Username'];
            $mail->Password = $config['Password'];
            $mail->SetFrom($config['Username'], $config['name']);

            /**
             * CONFIGURACION CUERPO QUE SE ENVIA Y CUENTA QUE RECIBE
             */
            $mail->Subject = $USUARIO['Subject'];
            $mail->msgHTML($bodyMessage); //Cuerpo del mensaje HTML o Text Plains
            // $mail->AddAddress($send_mail_config['mailTest']); //Este correo solamente lo envia cuando este en modo pruebas al administrador
            $mail->AddAddress($USUARIO['email']);
            if (!$mail->Send()) {
                return "Mailer Error: " . $mail->ErrorInfo;
            } else {
                return "Mensaje enviado correctamente";
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
