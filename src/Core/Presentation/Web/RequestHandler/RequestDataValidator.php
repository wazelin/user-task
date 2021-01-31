<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Web\RequestHandler;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDataValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @param mixed $requestData
     *
     * @throws InvalidRequestException
     */
    public function validate(mixed $requestData): void
    {
        $requestViolationMessages = [];

        /** @var ConstraintViolationInterface $constraintViolation */
        foreach ($this->validator->validate($requestData) as $constraintViolation) {
            $requestViolationMessages[] =
                "{$constraintViolation->getPropertyPath()}: {$constraintViolation->getMessage()}";
        }

        if ($requestViolationMessages) {
            throw new InvalidRequestException(implode(', ', $requestViolationMessages));
        }
    }
}
