<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Presentation\Web\Responder\JsonResponder;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;
use Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json\TaskView;

final class GetTaskResponder
{
    public function __construct(private JsonResponder $responder)
    {
    }

    public function respond(TaskProjection $task): Response
    {
        return $this->responder->respond(
            new TaskView($task)
        );
    }
}
