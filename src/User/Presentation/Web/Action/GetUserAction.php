<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Core\Presentation\Web\Responder\EmptyResponder;
use Wazelin\UserTask\User\Business\Service\UserSearchService;
use Wazelin\UserTask\User\Presentation\Web\RequestHandler\GetUserRequestHandler;
use Wazelin\UserTask\User\Presentation\Web\Responder\GetUserResponder;

/**
 * @Route("{id}", methods={"GET"})
 */
class GetUserAction
{
    public function __construct(
        private GetUserRequestHandler $requestHandler,
        private UserSearchService $service,
        private GetUserResponder $responder,
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
