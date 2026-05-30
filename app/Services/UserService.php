<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Mappers\UserMapper;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Request\LoginRequest;
use App\Request\RegisterUserRequest;
use App\Validation\Validator;

class UserService
{
    public function __construct(
        private UserRepository $repo,
        private Validator $validator
    ) {}

    /* =========================
        REGISTER
    ========================= */
   public function register(UserDTO $dto): bool
{
    $data = [
        'name' => $dto->name,
        'email' => $dto->email,
        'password' => $dto->password,
        'confirm_password' => $dto->confirmPassword
    ];

    $errors = $this->validator->validate(
        $data,
        RegisterUserRequest::rules()
    );

    if (!empty($errors)) {
        throw new ValidationException(
            "Validation failed",
            $errors
        );
    }

    if ($this->repo->findByEmail($dto->email)) {
        throw new ValidationException(
            "Validation failed",
            ['email' => 'Email already exists']
        );
    }

    $user = UserMapper::toModel($dto);

    $user->setPasswordHash(
        password_hash($dto->password, PASSWORD_DEFAULT)
    );

    return $this->repo->insertUser($user);
}

    /* =========================
        LOGIN
    ========================= */
   public function login(UserDTO $dto): array
{
    $data = [
        'email' => $dto->email,
        'password' => $dto->password
    ];

    $errors = $this->validator->validate($data, LoginRequest::rules());

    if (!empty($errors)) {
        throw new ValidationException(
            "Validation failed",
            $errors
        );
    }

    $user = $this->repo->findByEmail($dto->email);

    if (!$user) {
        throw new NotFoundException("User not found");
    }

    if (!password_verify($dto->password, $user->getPasswordHash())) {
        throw new ValidationException(
            "Invalid credentials",
            ['password' => 'Invalid password']
        );
    }

    return $user->toArray();
}

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }
}