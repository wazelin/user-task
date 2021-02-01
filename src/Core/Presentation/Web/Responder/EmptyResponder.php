<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Contract\WebResponderInterface;

class EmptyResponder implements WebResponderInterface
{
    public function respond(mixed $payload = null, int $statusCode = Response::HTTP_OK, array $headers = []): Response
    {
        return new Response(null, $statusCode, $headers);
    }
}
