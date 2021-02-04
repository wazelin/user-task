<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\DataAccess\Command\CommandDispatcher;
use Wazelin\UserTask\Task\Presentation\Web\RequestHandler\UpdateTaskRequestHandler;
use Wazelin\UserTask\Task\Presentation\Web\Responder\UpdateTaskResponder;

/**
 * @Route("{id}", methods={"PATCH"})
 */
class UpdateTaskAction
{
    public function __construct(
        private UpdateTaskRequestHandler $requestHandler,
        private CommandDispatcher $commandDispatcher,
        private UpdateTaskResponder $responder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $command = $this->requestHandler->handle($request);

        $this->commandDispatcher->dispatch($command);

        return $this->responder->respond();
    }
}
