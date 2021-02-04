<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Countable;
use IteratorAggregate;
use Wazelin\UserTask\Core\Contract\DomainIterator;

class UserCollectionProjection implements DomainIterator, IteratorAggregate, Countable
{
    /** @var UserProjection[] */
    private array $userProjections;

    public function __construct(UserProjection ...$userProjections)
    {
        $this->userProjections = $userProjections;
    }

    /**
     * @return UserProjection[]
     */
    public function getIterator(): iterable
    {
        yield from $this->userProjections;
    }

    public function count(): int
    {
        return count($this->userProjections);
    }
}
