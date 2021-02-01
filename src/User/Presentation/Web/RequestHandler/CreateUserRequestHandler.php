<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\RequestHandler;

use Symfony\Component\HttpFoundation\Request;
use TypeError;
use Wazelin\UserTask\Core\Business\Service\IdGeneratorService;
use Wazelin\UserTask\Core\Contract\WebRequestDataExtractorInterface;
use Wazelin\UserTask\Core\Contract\Exception\InvalidRequestException;
use Wazelin\UserTask\Core\Presentation\Web\RequestHandler\RequestDataValidator;
use Wazelin\UserTask\User\Business\Command\CreateUserCommand;
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
        try {
            $requestData = new UserDto(
                ...$this->extractor->extract($request)
            );
        } catch (TypeError $error) {
            throw new InvalidRequestException(
                $error->getMessage(),
                $error->getCode(),
                $error
            );
        }

        $this->validator->validate($requestData);

        return new CreateUserCommand(
            $this->idGenerator->generate(),
            $requestData->getName()
        );
    }
}
