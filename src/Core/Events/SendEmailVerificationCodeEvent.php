<?php


namespace App\Core\Events;


use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SendEmailVerificationCodeEvent
{
    public function __invoke(string $email,string $code)
    {
        /**
         * @todo queue mail && make class for mail
         */
        $mail = new PHPMailer(false);
        try {

            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = getenv("MAIL_HOST");
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv("MAIL_USERNAME");
            $mail->Password   = getenv("acb9029582ee31");
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = getenv("MAIL_PORT");

            $mail->setFrom(getenv('MAIL_SENDER_ADDRESS'), getenv('MAIL_SENDER_NAME'));
            $mail->addAddress($email);     //Add a recipient

            $mail->isHTML(true);  //Set email format to HTML
            $mail->Subject = 'Forget password code';
            $mail->Body    = "Your code is <b>$code</b>";

            $mail->send();
        }catch (Exception $e){
            var_dump($e);
        }
    }
}