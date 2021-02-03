<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Presentation\Web\Responder\JsonResponder;
use Wazelin\UserTask\User\Business\Domain\UserProjection;
use Wazelin\UserTask\User\Presentation\Web\Responder\View\Json\UsersView;

final class GetUsersResponder
{
    public function __construct(private JsonResponder $responder)
    {
    }

    public function respond(UserProjection ...$users): Response
    {
        return $this->responder->respond(
            new UsersView(...$users)
        );
    }
}
