<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Traits;

use Broadway\ReadModel\Repository;
use Wazelin\UserTask\Core\Contract\IdentifiableSearchRequestInterface;

trait IdentifiableSearchRequestRepositoryTrait
{
    protected function findByIdentifier(IdentifiableSearchRequestInterface $searchRequest): ?array
    {
        if ($searchRequest->isEmpty()) {
            return $this->getRepository()->findAll();
        }

        if ($searchRequest->hasIdOnly()) {
            $entity = $this->getRepository()->find($searchRequest->getId());

            return $entity ? [$entity] : [];
        }

        return null;
    }

    abstract protected function getRepository(): Repository;
}
