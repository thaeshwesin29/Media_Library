<?php

namespace App\Error;

class Response
{
    public function __construct(
        public int $statusCode = 500,
        public string $message = '',
        public array $data = [],
        public string $view = '500',

        // 🔥 DEBUG INFO (NEW)
        public ?string $file = null,
        public ?int $line = null,
        public ?string $trace = null
    ) {}

    /**
     * Attach exception debug info safely
     */
    public static function fromException(\Throwable $e, string $view = '500'): self
    {
        return new self(
            statusCode: 500,
            message: $e->getMessage(),
            data: [],
            view: $view,
            file: $e->getFile(),
            line: $e->getLine(),
            trace: $e->getTraceAsString()
        );
    }

    /**
     * Create 404 response easily
     */
    public static function notFound(string $message = 'Not Found'): self
    {
        return new self(
            statusCode: 404,
            message: $message,
            view: '404'
        );
    }

    /**
     * Create success response (optional API use)
     */
    public static function success(array $data = []): self
    {
        return new self(
            statusCode: 200,
            message: 'OK',
            data: $data,
            view: 'success'
        );
    }
}