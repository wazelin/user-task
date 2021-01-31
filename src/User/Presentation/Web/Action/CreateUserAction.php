<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\Contract\WebResponderInterface;
use Wazelin\UserTask\Core\DataAccess\Command\CommandDispatcher;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\CreateUserRequestHandler;

/**
 * @Route(methods={"POST"})
 */
class CreateUserAction
{
    public function __construct(
        private CreateUserRequestHandler $requestHandler,
        private CommandDispatcher $commandDispatcher,
        private WebResponderInterface $responder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $this->commandDispatcher->dispatch(
            $this->requestHandler->handle($request)
        );

        return $this->responder->respond(statusCode: Response::HTTP_ACCEPTED);
    }
}
