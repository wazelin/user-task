<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder;

use Symfony\Component\HttpFoundation\Response;
use Wazelin\UserTask\Core\Presentation\Web\Responder\JsonResponder;
use Wazelin\UserTask\User\Business\Domain\User;
use Wazelin\UserTask\User\Presentation\Web\Responder\View\Json\UserView;

class GetUserResponder
{
    public function __construct(private JsonResponder $responder)
    {
    }

    public function respond(User $user): Response
    {
        return $this->responder->respond(
            new UserView($user)
        );
    }
}
