<?php

namespace App\Validation;

class Validator
{
    public function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = isset($data[$field]) ? trim((string)$data[$field]) : '';

            // REQUIRED
            if (($fieldRules['required'] ?? false) && $value === '') {
                $errors[$field] = ucfirst($field) . " is required";
                continue;
            }

            if ($value === '') {
                continue;
            }

            // MIN
            if (isset($fieldRules['min']) && strlen($value) < $fieldRules['min']) {
                $errors[$field] = ucfirst($field) . " must be at least {$fieldRules['min']} characters";
                continue;
            }

            // MAX
            if (isset($fieldRules['max']) && strlen($value) > $fieldRules['max']) {
                $errors[$field] = ucfirst($field) . " must not exceed {$fieldRules['max']} characters";
                continue;
            }

            // EMAIL
            if (($fieldRules['email'] ?? false) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "Invalid email format";
                continue;
            }

            // MATCH
            if (isset($fieldRules['match'])) {
                $matchField = $fieldRules['match'];
                $matchValue = $data[$matchField] ?? '';

                if ($value !== $matchValue) {
                    $errors[$field] = ucfirst($field) . " must match " . ucfirst($matchField);
                    continue;
                }
            }

            // STRONG PASSWORD
            if (($fieldRules['strong'] ?? false)) {
                if (!preg_match('/[A-Z]/', $value) ||
                    !preg_match('/[a-z]/', $value) ||
                    !preg_match('/[0-9]/', $value)) {
                    $errors[$field] = ucfirst($field) . " must include uppercase, lowercase and number";
                    continue;
                }
            }
        }

        return $errors;
    }
}