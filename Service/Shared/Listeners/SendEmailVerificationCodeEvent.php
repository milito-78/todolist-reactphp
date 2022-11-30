<?php
namespace Service\Shared\Listeners;

use Application\Codes\Commands\SendCode\ISendCodeCommand;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use React\EventLoop\Loop;
use Service\Shared\Helpers\Helpers;

use function React\Promise\resolve;

class SendEmailVerificationCodeEvent
{
    public function __construct(
        private ISendCodeCommand $command
    )
    {
    }

    public function __invoke(string $email,string $code)
    {
        $this->command->Execute($email,$code);
    }
    
}