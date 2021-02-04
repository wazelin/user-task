<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\User\Business\Service\UserSearchService;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\GetUserRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\GetUserTaskResponder;

/**
 * @Route("{id}/tasks/{taskId}", methods={"GET"})
 */
class GetUserTaskAction
{
    public function __construct(
        private GetUserRequestHandler $requestHandler,
        private UserSearchService $service,
        private GetUserTaskResponder $responder,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $tasks = $this->service->findOneOrFail(
            $this->requestHandler->handle($request)
        )
            ->getTasks();


        $taskId = $request->attributes->get('taskId');

        if (!isset($tasks[$taskId])) {
            throw EntityNotFoundException::create('User task');
        }

        return $this->responder->respond(
            $tasks[$taskId]
        );
    }
}
