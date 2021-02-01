<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests\Unit\User\Command;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\User\Business\Domain\User;
use Wazelin\UserTask\User\Business\Domain\UserEvent\UserWasCreatedEvent;
use Wazelin\UserTask\User\Command\CreateUserCommand;
use Wazelin\UserTask\User\Command\CreateUserCommandHandler;

class CreateUserCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    private UuidGeneratorInterface $uuidGenerator;

    /**
     * @before
     */
    public function init(): void
    {
        $this->uuidGenerator = new Version4Generator();
    }

    /**
     * @param string $name
     *
     * @testWith ["Alice"]
     *           ["Bob"]
     */
    public function testCreateNewUser(string $name): void
    {
        $id = $this->uuidGenerator->generate();

        $this->scenario
            ->withAggregateId($id)
            ->when(new CreateUserCommand(new Id($id), $name))
            ->then([new UserWasCreatedEvent(new Id($id), $name)]);
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new CreateUserCommandHandler(
            new EventSourcingRepository($eventStore, $eventBus, User::class, new PublicConstructorAggregateFactory())
        );
    }
}