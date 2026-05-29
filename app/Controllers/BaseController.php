<?php

namespace App\Controllers;

use App\DTO\UserDTO;

/**
 * Base Controller
 * Shared helper methods for all controllers
 */
abstract class BaseController
{
    /**
     * Render a view file
     */
    protected function view(string $path, array $data = []): void
    {
        extract($data);

        require BASE_PATH . '/resources/views/' . $path . '.php';
    }

    /**
     * Redirect helper
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    /**
     * JSON response helper (for APIs)
     */
    protected function json(array $data, int $code = 200): void
    {
        http_response_code($code);

        header('Content-Type: application/json');

        echo json_encode($data, JSON_PRETTY_PRINT);

        exit;
    }

    /**
     * Get GET parameter safely
     */
    protected function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Get POST parameter safely
     */
    protected function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * ✅ FIXED: Protects routes from non-logged-in sessions
     */
    protected function requireLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Changed from 'user' to 'user_id'
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login first';
            // Configured explicit BASE_URL to prevent route drop
            $this->redirect(BASE_URL . '/Public/index.php?page=login');
        }
    }

    /**
     * ✅ FIXED: Blocks logged-in users from revisiting login/register pages
     */
    protected function guestOnly(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Changed from 'user' to 'user_id'
        if (isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/Public/index.php?page=home');
        }
    }

    /**
     * ✅ FIXED: Mapped to safe dynamic structure matching view expectations
     */
    protected function user(): ?array
    {
        if (isset($_SESSION['user_id'])) {
            return [
                'id'   => $_SESSION['user_id'],
                'name' => $_SESSION['username'] ?? 'User'
            ];
        }

        return null;
    }

    /**
     * ✅ FIXED: Changed to match active login session tracking array
     */
    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}