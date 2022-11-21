<?php
namespace Service\Users\Common\Resources;

use Domain\Users\User;

class UserResource implements IArrayable{

    /**
     */
    public function __construct(private mixed $user) {
    }

    public function toArray():array {
        /**
         * @var User $item
         */
        $item = $this->user;
        return [
            "id"            => $item->id,
            "full_name"     => $item->full_name,
            "email"         => $item->email,
            "api_key"       => $item->api_key,
            "created_at"    => $item->getCreatedAtDateTimeString(),
            "updated_at"    => $item->getUpdatedAtDateTimeString()
        ];
    }
}