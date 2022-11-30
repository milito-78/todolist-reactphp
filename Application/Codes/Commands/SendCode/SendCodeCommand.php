<?php
namespace Application\Codes\Commands\SendCode;

use PHPMailer\PHPMailer\PHPMailer;
use React\EventLoop\Loop;
use Exception;
use PHPMailer\PHPMailer\SMTP;
use Service\Shared\Helpers\Helpers;

class SendCodeCommand implements ISendCodeCommand{

	/**
	 * @param string $email
	 * @param string $code
	 * @return void
	 */
	public function Execute(string $email, string $code) {
        Loop::addTimer(0.5,function()use($email,$code){
            $mail = new PHPMailer(true);
            try {
    
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = envGet("MAIL_HOST");
                $mail->SMTPAuth   = true;
                $mail->Username   = envGet("MAIL_USERNAME");
                $mail->Password   = envGet("MAIL_PASSWORD");
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = envGet("MAIL_PORT");
    
                $mail->setFrom(envGet('MAIL_SENDER_ADDRESS'), envGet('MAIL_SENDER_NAME'));
                $mail->addAddress($email);     //Add a recipient
    
                $mail->isHTML(true);  //Set email format to HTML
                $mail->Subject = 'Forget password code';
                $mail->Body    = "Your code is <b>$code</b>";
    
                $mail->send();
            }catch (Exception $e){
                Helpers::emit("server","error",[$e]);
            }
        });
	}
}