<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Task\Contract\TaskSearchServiceInterface;
use Wazelin\UserTask\Task\Presentation\Web\RequestHandler\GetTaskRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\GetUserTaskResponder;

/**
 * @Route("{userId}/tasks/{id}", methods={"GET"})
 */
class GetUserTaskAction
{
    public function __construct(
        private GetTaskRequestHandler $requestHandler,
        private TaskSearchServiceInterface $service,
        private GetUserTaskResponder $responder,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $task = $this->service->findOneOrFail(
            $this->requestHandler->handle($request)
        );


        $userId = $request->attributes->get('userId');

        if ($task->getAssigneeId() !== $userId) {
            throw EntityNotFoundException::create('User task');
        }

        return $this->responder->respond($task);
    }
}
