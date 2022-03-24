<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token){
        $this ->email = $email;
        $this ->nombre = $nombre;
        $this ->token = $token;
    }

    public function enviarConfirmacion(){
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '4323f2ed3de5b0';
        $mail->Password = '1d69d752f0ade7';

        $mail ->setFrom('cuentas@appsalon.com');
        $mail ->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail ->Subjet='Confirma tu cuenta';
        //Set HTML
        $mail ->isHTML(TRUE);
        $mail ->CharSet ='UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong> Has creado tu cuenta en AppSalon, sólo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí <a href='http://localhost:3000/confirmar?token=".$this->token."'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tú no solicitaste éste cambio a esta cuenta puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail ->Body=$contenido;
        //Enviar el email
        $mail ->send();
    }
    public function enviarInstrucciones(){
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '4323f2ed3de5b0';
        $mail->Password = '1d69d752f0ade7';

        $mail ->setFrom('cuentas@appsalon.com');
        $mail ->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail ->Subjet='Reestablece tu password';
        //Set HTML
        $mail ->isHTML(TRUE);
        $mail ->CharSet ='UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong>Has solicitado reestablecer tu password. Da click en el link en el siguiente enlace para reestablecer tu password</p>";
        $contenido .= "<p>Presiona aquí <a href='http://localhost:3000/recuperar?token=".$this->token."'>Reestablecer password</a></p>";
        $contenido .= "<p>Si tú no solicitaste éste cambio a esta cuenta puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail ->Body=$contenido;
        //Enviar el email
        $mail ->send();
    }
}