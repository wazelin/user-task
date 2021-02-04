<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Presentation\Web\Responder\JsonResponder;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;
use Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json\PureTaskView;

class GetUserTaskResponder
{
    public function __construct(private JsonResponder $responder)
    {
    }

    public function respond(TaskProjectionInterface $task): Response
    {
        return $this->responder->respond(
            new PureTaskView($task)
        );
    }
}
