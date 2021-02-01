<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\DataAccess\Command\CommandDispatcher;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\CreateUserRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\CreateUserResponder;

/**
 * @Route(methods={"POST"})
 */
class CreateUserAction
{
    public function __construct(
        private CreateUserRequestHandler $requestHandler,
        private CommandDispatcher $commandDispatcher,
        private CreateUserResponder $responder
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
