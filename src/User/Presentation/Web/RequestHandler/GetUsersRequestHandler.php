<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\User\Business\Query\GetUsersQuery;
use Wazelin\UserTask\User\Presentation\Web\Request\FindUsersDto;

class GetUsersRequestHandler
{
    public function __construct(private RequestDataValidator $validator)
    {
    }

    /**
     * @param Request $request
     * @return GetUsersQuery
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): GetUsersQuery
    {
        try {
            $requestData = new FindUsersDto(
                ...$request->query->all()
            );
        } catch (TypeError $error) {
            throw new InvalidRequestException(
                $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->validator->validate($requestData);

        return new GetUsersQuery(
            $requestData->getId(),
            $requestData->getName()
        );
    }
}
