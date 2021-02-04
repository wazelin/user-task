<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Assignment\Contract\AssignmentSearchServiceInterface;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\GetUserTasksRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\GetUserTasksResponder;

/**
 * @Route("{id}/tasks", methods={"GET"})
 */
class GetUserTasksAction
{
    public function __construct(
        private GetUserTasksRequestHandler $requestHandler,
        private AssignmentSearchServiceInterface $service,
        private GetUserTasksResponder $responder,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        return $this->responder->respond(
            ...$this->service->find(
            $this->requestHandler->handle($request)
        )
        );
    }
}
