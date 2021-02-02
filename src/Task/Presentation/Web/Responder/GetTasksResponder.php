<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Presentation\Web\Responder\JsonResponder;
use Wazelin\UserTask\Task\Business\Domain\ReadModel\Task;
use Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json\TasksView;

final class GetTasksResponder
{
    public function __construct(private JsonResponder $responder)
    {
    }

    public function respond(Task ...$tasks): Response
    {
        return $this->responder->respond(
            new TasksView(...$tasks)
        );
    }
}
