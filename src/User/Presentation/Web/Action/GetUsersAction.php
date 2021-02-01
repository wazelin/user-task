<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\User\Business\Service\UserSearchService;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\GetUsersRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\GetUsersResponder;

/**
 * @Route(methods={"GET"})
 */
class GetUsersAction
{
    public function __construct(
        private GetUsersRequestHandler $requestHandler,
        private UserSearchService $service,
        private GetUsersResponder $responder,
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
