<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Assignment\Business\Command\UnassignCommand;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\Request\IdDto;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;

class UnassignTaskRequestHandler
{
    public function __construct(private RequestDataValidator $validator)
    {
    }

    /**
     * @param Request $request
     * @return UnassignCommand
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): UnassignCommand
    {
        try {
            $userId = new IdDto(
                $request->attributes->get('id')
            );
            $taskId = new IdDto(
                $request->attributes->get('taskId')
            );
        } catch (TypeError $error) {
            throw new InvalidRequestException(
                $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->validator->validate($userId);
        $this->validator->validate($taskId);

        return new UnassignCommand(
            new Id(
                $userId->getId()
            ),
            new Id(
                $taskId->getId()
            )
        );
    }
}
