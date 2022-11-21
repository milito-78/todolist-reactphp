<?php 
namespace Application\Codes\Commands\CreateCode;

class SendBeforeModel{
    /**
     */
    public function __construct(
        public string $code,
        public string $token,
        public int $expire,
    ) {
    }
}