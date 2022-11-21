<?php 
namespace Application\Codes\Commands\SaveCode;

class SaveCodeModel{
    /**
     */
    public function __construct(
        public string $code,
        public string $token,
        public int $expire,
    ) {
    }
}