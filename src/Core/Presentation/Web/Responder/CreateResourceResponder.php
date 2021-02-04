<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Business\Domain\Id;

final class CreateResourceResponder
{
    public function __construct(private EmptyResponder $responder)
    {
    }

    public function respond(string $location, Id $resourceId): Response
    {
        return $this->responder->respond(
            statusCode: Response::HTTP_ACCEPTED,
            headers: ['Location' => "$location/$resourceId"]
        );
    }
}
