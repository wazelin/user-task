<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Presentation\Web\Responder\EmptyResponder;

final class CreateTaskResponder
{
    public function __construct(private EmptyResponder $responder)
    {
    }

    public function respond(string $taskResourceLocation, Id $taskId): Response
    {
        return $this->responder->respond(
            statusCode: Response::HTTP_ACCEPTED,
            headers: ['Location' => "$taskResourceLocation/$taskId"]
        );
    }
}
