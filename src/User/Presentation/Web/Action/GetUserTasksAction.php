<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\User\Business\Service\UserSearchService;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\GetUserRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\GetUserTasksResponder;

/**
 * @Route("{id}/tasks", methods={"GET"})
 */
class GetUserTasksAction
{
    public function __construct(
        private GetUserRequestHandler $requestHandler,
        private UserSearchService $service,
        private GetUserTasksResponder $responder,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        return $this->responder->respond(
            ...$this->service->findOneOrFail(
                $this->requestHandler->handle($request)
            )
                ->getTasks()
        );
    }
}
