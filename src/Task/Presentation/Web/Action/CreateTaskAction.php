<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\DataAccess\Command\CommandDispatcher;
use Wazelin\UserTask\Task\Presentation\Web\RequestHandler\CreateTaskRequestHandler;
use Wazelin\UserTask\Task\Presentation\Web\Responder\CreateTaskResponder;

/**
 * @Route(methods={"POST"})
 */
class CreateTaskAction
{
    public function __construct(
        private CreateTaskRequestHandler $requestHandler,
        private CommandDispatcher $commandDispatcher,
        private CreateTaskResponder $responder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $command = $this->requestHandler->handle($request);

        $this->commandDispatcher->dispatch($command);

        return $this->responder->respond(
            $request->getUri(),
            $command->getId()
        );
    }
}