<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class InvalidRequestException extends ValidatorException implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
