<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Presentation\Web\Responder\EmptyResponder;

final class CreateUserResponder
{
    public function __construct(private EmptyResponder $responder)
    {
    }

    public function respond(string $userResourceLocation, Id $userId): Response
    {
        return $this->responder->respond(
            statusCode: Response::HTTP_ACCEPTED,
            headers: ['Location' => "$userResourceLocation/$userId"]
        );
    }
}
