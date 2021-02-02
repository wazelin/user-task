<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\Request\IdDto;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\Task\Business\Query\GetTaskQuery;

class GetTaskRequestHandler
{
    public function __construct(private RequestDataValidator $validator)
    {
    }

    /**
     * @param Request $request
     * @return GetTaskQuery
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): GetTaskQuery
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

        return new GetTaskQuery(
            $requestData->getId()
        );
    }
}
