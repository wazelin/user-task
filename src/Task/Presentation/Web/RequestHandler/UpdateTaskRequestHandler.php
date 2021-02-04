<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Business\Service\IdGeneratorService;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Contract\WebRequestDataExtractorInterface;
use Wazelin\UserTask\Core\Presentation\Web\Request\IdDto;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\Task\Business\Command\ChangeTaskStatusCommand;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\Task\Presentation\Web\Request\PatchTaskDto;

class UpdateTaskRequestHandler
{
    public function __construct(
        private WebRequestDataExtractorInterface $extractor,
        private RequestDataValidator $validator,
        private IdGeneratorService $idGenerator
    ) {
    }

    public function handle(Request $request): ChangeTaskStatusCommand
    {
        try {
            $id          = new IdDto(
                $request->attributes->get('id')
            );
            $requestData = new PatchTaskDto(
                ...$this->extractor->extract($request)
            );
        } catch (TypeError $error) {
            throw new InvalidRequestException(
                $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->validator->validate($id);
        $this->validator->validate($requestData);

        return new ChangeTaskStatusCommand(
            new Id(
                $id->getId()
            ),
            TaskStatus::fromString(
                $requestData->getStatus()
            )
        );
    }
}
