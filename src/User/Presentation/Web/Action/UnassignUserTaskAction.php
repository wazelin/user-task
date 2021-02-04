<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\DataAccess\Command\CommandDispatcher;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\UnassignTaskRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\AssignUserTaskResponder;

/**
 * @Route("{id}/tasks/{taskId}", methods={"DELETE"})
 */
class UnassignUserTaskAction
{
    public function __construct(
        private UnassignTaskRequestHandler $requestHandler,
        private CommandDispatcher $commandDispatcher,
        private AssignUserTaskResponder $responder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $command = $this->requestHandler->handle($request);

        $this->commandDispatcher->dispatch($command);

        return $this->responder->respond();
    }
}
