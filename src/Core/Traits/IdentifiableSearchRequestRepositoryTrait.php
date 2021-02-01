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
            $user = $this->getRepository()->find($searchRequest->getId());

            return $user ? [$user] : [];
        }

        return null;
    }

    abstract protected function getRepository(): Repository;
}
