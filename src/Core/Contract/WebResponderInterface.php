<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract;

use Symfony\Component\HttpFoundation\Response;

interface WebResponderInterface
{
    public function respond(mixed $payload = null, int $statusCode = Response::HTTP_OK, array $headers = []): Response;
}
