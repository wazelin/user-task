<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Contract\WebRequestDataExtractorInterface;
use Wazelin\UserTask\Core\Presentation\Web\Request\IdDto;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\Assignment\Business\Command\AssignCommand;

class AssignTaskRequestHandler
{
    public function __construct(
        private WebRequestDataExtractorInterface $extractor,
        private RequestDataValidator $validator
    ) {
    }

    /**
     * @param Request $request
     * @return AssignCommand
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): AssignCommand
    {
        try {
            $userId = new IdDto(
                $request->attributes->get('id')
            );
            $taskId = new IdDto(
                ...$this->extractor->extract($request)
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

        return new AssignCommand(
            new Id(
                $userId->getId()
            ),
            new Id(
                $taskId->getId()
            )
        );
    }
}
