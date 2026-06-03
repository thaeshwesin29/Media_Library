<?php

namespace App\Services;

use App\Domain\User\Email;
use App\Domain\User\Name;
use App\Domain\User\Password;
use App\Domain\User\User;
use App\DTO\UserDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
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
        // 1️⃣ Validate input (Application Layer)
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

        // 2️⃣ Check duplicate email
        if ($this->repo->findByEmail($dto->email)) {
            throw new ValidationException(
                "Validation failed",
                ['email' => 'Email already exists']
            );
        }

        // 3️⃣ Create DOMAIN entity (DDD)
        $user = User::register(
            new Name($dto->name),
            new Email($dto->email),
            new Password($dto->password)
        );

        // 4️⃣ Save to DB
        return $this->repo->insertUser($user);
    }

    /* =========================
        LOGIN
    ========================= */
    public function login(UserDTO $dto): array
    {
        // 1️⃣ Validate input
        $data = [
            'email' => $dto->email,
            'password' => $dto->password
        ];

        $errors = $this->validator->validate(
            $data,
            LoginRequest::rules()
        );

        if (!empty($errors)) {
            throw new ValidationException(
                "Validation failed",
                $errors
            );
        }

        // 2️⃣ Find user
        $user = $this->repo->findByEmail($dto->email);

        if (!$user) {
            throw new NotFoundException("User not found");
        }

        // 3️⃣ DOMAIN handles password verification
        if (!$user->verifyPassword($dto->password)) {
            throw new ValidationException(
                "Invalid credentials",
                ['password' => 'Invalid password']
            );
        }

        // 4️⃣ Return safe data (NO password)
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ];
    }

    /* =========================
        LOGOUT
    ========================= */
    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    /* =========================
        GET USER (OPTIONAL USE CASE)
    ========================= */
    public function getById(int $id): array
    {
        $user = $this->repo->findById($id);

        if (!$user) {
            throw new NotFoundException("User not found");
        }

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ];
    }

    /* =========================
        DELETE USER (OPTIONAL)
    ========================= */
    public function delete(int $id): bool
    {
        $user = $this->repo->findById($id);

        if (!$user) {
            throw new NotFoundException("User not found");
        }

        return $this->repo->deleteUser($id);
    }
}