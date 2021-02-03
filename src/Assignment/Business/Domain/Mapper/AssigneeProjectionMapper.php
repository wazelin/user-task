<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Domain\Mapper;

use Wazelin\UserTask\Assignment\Business\Domain\AssigneeProjection;
use Wazelin\UserTask\User\Business\Domain\UserProjectionInterface;

class AssigneeProjectionMapper
{
    public function mapFromUserProjection(UserProjectionInterface $userProjection): AssigneeProjection
    {
        return new AssigneeProjection(
            $userProjection->getId(),
            $userProjection->getName()
        );
    }
}
