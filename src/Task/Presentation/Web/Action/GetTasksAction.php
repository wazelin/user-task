<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Task\Business\Service\TaskSearchService;
use Wazelin\UserTask\Task\Presentation\Web\RequestHandler\GetTasksRequestHandler;
use Wazelin\UserTask\Task\Presentation\Web\Responder\GetTasksResponder;

/**
 * @Route(methods={"GET"})
 */
class GetTasksAction
{
    public function __construct(
        private GetTasksRequestHandler $requestHandler,
        private TaskSearchService $service,
        private GetTasksResponder $responder,
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
