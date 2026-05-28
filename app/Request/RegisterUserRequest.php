<?php

namespace App\Request;

class RegisterUserRequest
{
    public static function rules(): array
    {
        return [
            'name' => [
                'required' => true,
                'min' => 3
            ],
            'email' => [
                'required' => true,
                'email' => true
            ],
            'password' => [
                'required' => true,
                'min' => 6,
                'strong' => true
            ],
            'confirm_password' => [
                'required' => true,
                'match' => 'password'
            ]
        ];
    }
}