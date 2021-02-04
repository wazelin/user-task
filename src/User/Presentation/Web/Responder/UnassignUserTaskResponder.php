<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Presentation\Web\Responder\EmptyResponder;

final class UnassignUserTaskResponder
{
    public function __construct(private EmptyResponder $responder)
    {
    }

    public function respond(): Response
    {
        return $this->responder->respond(statusCode: Response::HTTP_ACCEPTED);
    }
}
