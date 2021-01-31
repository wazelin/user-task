<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use Wazelin\UserTask\Core\Business\Service\IdGeneratorService;
use Wazelin\UserTask\Core\Contract\WebRequestDataExtractorInterface;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\User\Command\CreateUserCommand;
use Wazelin\UserTask\User\Presentation\Web\Request\UserDto;

class CreateUserRequestHandler
{
    public function __construct(
        private WebRequestDataExtractorInterface $extractor,
        private RequestDataValidator $validator,
        private IdGeneratorService $idGenerator
    ) {
    }

    /**
     * @param Request $request
     * @return CreateUserCommand
     *
     * @throws InvalidRequestException
     */
    public function handle(Request $request): CreateUserCommand
    {
        $requestData = new UserDto(
            ...$this->extractor->extract($request)
        );

        $this->validator->validate($requestData);

        return new CreateUserCommand(
            $this->idGenerator->generate(),
            $requestData->getName()
        );
    }
}
