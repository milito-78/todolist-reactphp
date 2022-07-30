<?php
namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Inputs\ChangePasswordInput;
use Core\Exceptions\ValidationException;

class ChangePasswordUseCase implements ChangePasswordUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(ChangePasswordInput $input)
    {
        $input->validate();
        $user   = $input->request()->getAuth();

        if (!password_verify($input->currentPassword() , $user["password"])){
            throw new ValidationException("current password is incorrect");
        }

        if ($input->currentPassword() == $input->password()){
            throw new ValidationException("The new password must not be the same as the current password");
        }

        return $this->userRepository->update($user["id"],[
                "password" => $input->passwordHashed()
            ])->then(function ($res) {
                return json_no_content();
            });

    }
}