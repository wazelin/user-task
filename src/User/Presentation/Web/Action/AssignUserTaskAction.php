<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\DataAccess\Command\CommandDispatcher;
use Wazelin\UserTask\Core\Presentation\Web\Responder\CreateResourceResponder;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\AssignTaskRequestHandler;

/**
 * @Route("{id}/tasks", methods={"POST"})
 */
class AssignUserTaskAction
{
    public function __construct(
        private AssignTaskRequestHandler $requestHandler,
        private CommandDispatcher $commandDispatcher,
        private CreateResourceResponder $responder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $command = $this->requestHandler->handle($request);

        $this->commandDispatcher->dispatch($command);

        return $this->responder->respond(
            $request->getUri(),
            $command->getTaskId()
        );
    }
}
