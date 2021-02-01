<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\RequestHandler;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Wazelin\UserTask\Core\Business\Service\IdGeneratorService;
use Wazelin\UserTask\Core\Contract\WebRequestDataExtractorInterface;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\Task\Business\Command\CreateTaskCommand;
use Wazelin\UserTask\Task\Presentation\Web\Request\TaskDto;

class CreateTaskRequestHandler
{
    public function __construct(
        private WebRequestDataExtractorInterface $extractor,
        private RequestDataValidator $validator,
        private IdGeneratorService $idGenerator
    ) {
    }

    public function handle(Request $request): CreateTaskCommand
    {
        $requestData = new TaskDto(
            ...$this->extractor->extract($request)
        );

        $this->validator->validate($requestData);

        return new CreateTaskCommand(
            $this->idGenerator->generate(),
            $requestData->getSummary(),
            $requestData->getDescription(),
            null === $requestData->getDueDate()
                ? null
                : new DateTimeImmutable($requestData->getDueDate())
        );
    }
}
