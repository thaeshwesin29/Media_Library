<?php

namespace App\Error;

namespace App\Error;

use Throwable;

class Dispatcher
{
    public function __construct(
        private Resolver $resolver,
        private Renderer $renderer
    ) {}

    public function handle(Throwable $e): void
{
    $handler = $this->resolver->resolve($e);

    $response = $handler->handle($e); // important

    $this->renderer->render($response);
}
}