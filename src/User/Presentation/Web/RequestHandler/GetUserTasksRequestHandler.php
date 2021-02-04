<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Assignment\Business\Query\AssignmentsSearchQuery;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\Request\IdDto;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\Task\Presentation\Web\Request\FindTasksDto;

class GetUserTasksRequestHandler
{
    public function __construct(private RequestDataValidator $validator)
    {
    }

    /**
     * @param Request $request
     * @return AssignmentsSearchQuery
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): AssignmentsSearchQuery
    {
        try {
            $userRequestData = new IdDto(
                $request->attributes->get('id')
            );
            $taskRequestData = new FindTasksDto(
                ...$request->query->all()
            );
        } catch (TypeError $error) {
            throw new InvalidRequestException(
                $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->validator->validate($userRequestData);
        $this->validator->validate($taskRequestData);

        return new AssignmentsSearchQuery(
            $userRequestData->getId(),
            null === $taskRequestData->getStatus()
                ? null
                : TaskStatus::fromString($taskRequestData->getStatus()),
            null === $taskRequestData->getDueDate()
                ? null
                : new DateTimeImmutable($taskRequestData->getDueDate())
        );
    }
}
