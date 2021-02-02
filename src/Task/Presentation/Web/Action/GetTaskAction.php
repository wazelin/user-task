<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Core\Presentation\Web\Responder\EmptyResponder;
use Wazelin\UserTask\Task\Business\Service\TaskSearchService;
use Wazelin\UserTask\Task\Presentation\Web\RequestHandler\GetTaskRequestHandler;
use Wazelin\UserTask\Task\Presentation\Web\Responder\GetTaskResponder;

/**
 * @Route("{id}", methods={"GET"})
 */
class GetTaskAction
{
    public function __construct(
        private GetTaskRequestHandler $requestHandler,
        private TaskSearchService $service,
        private GetTaskResponder $responder,
        private EmptyResponder $errorResponder
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            return $this->responder->respond(
                $this->service->findOneOrFail(
                    $this->requestHandler->handle($request)
                )
            );
        } catch (EntityNotFoundException) {
            return $this->errorResponder->respond(
                statusCode: Response::HTTP_NOT_FOUND
            );
        }
    }
}
