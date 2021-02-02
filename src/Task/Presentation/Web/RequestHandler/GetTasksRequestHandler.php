<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\RequestHandler;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\Task\Business\Query\GetTasksQuery;
use Wazelin\UserTask\Task\Presentation\Web\Request\FindTasksDto;

class GetTasksRequestHandler
{
    public function __construct(private RequestDataValidator $validator)
    {
    }

    /**
     * @param Request $request
     * @return GetTasksQuery
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): GetTasksQuery
    {
        try {
            $requestData = new FindTasksDto(
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

        return new GetTasksQuery(
            null === $requestData->getStatus()
                ? null
                : TaskStatus::fromString($requestData->getStatus()),
            null === $requestData->getDueDate()
                ? null
                : new DateTimeImmutable($requestData->getDueDate())
        );
    }
}
