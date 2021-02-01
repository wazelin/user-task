<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\User\Business\Query\GetUserQuery;
use Wazelin\UserTask\User\Presentation\Web\Request\FindUserDto;

class GetUserRequestHandler
{
    public function __construct(private RequestDataValidator $validator)
    {
    }

    /**
     * @param Request $request
     * @return GetUserQuery
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): GetUserQuery
    {
        $requestData = new FindUserDto(
            $request->attributes->get('id')
        );

        $this->validator->validate($requestData);

        return new GetUserQuery(
            $requestData->getId()
        );
    }
}
