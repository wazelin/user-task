<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\Request\IdDto;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\User\Business\Query\GetUserQuery;

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
        try {
            $requestData = new IdDto(
                $request->attributes->get('id')
            );
        } catch (TypeError $error) {
            throw new InvalidRequestException(
                $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->validator->validate($requestData);

        return new GetUserQuery(
            $requestData->getId()
        );
    }
}
