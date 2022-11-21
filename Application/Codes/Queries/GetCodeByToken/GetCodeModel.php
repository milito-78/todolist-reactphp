<?php
namespace Application\Codes\Queries\GetCodeByToken;

class GetCodeModel{
    public function __construct(
        public string $code,
        public int $expire_secs,
        public int $expired_at
    )
    {
    }
}