<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Contract\WebResponderInterface;

final class JsonResponder implements WebResponderInterface
{
    private const ENCODING_OPTIONS = JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION;

    public function respond(mixed $payload = null, int $statusCode = Response::HTTP_OK, array $headers = []): Response
    {
        $response = new JsonResponse(status: $statusCode, headers: $headers);

        if (null !== $payload) {
            $response->setEncodingOptions(self::ENCODING_OPTIONS);
            $response->setData($payload);
        }

        return $response;
    }
}
