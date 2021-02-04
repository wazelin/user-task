<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests\Unit\Task\Command;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use DateTimeImmutable;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Command\ChangeTaskStatusCommand;
use Wazelin\UserTask\Task\Business\Command\ChangeTaskStatusCommandHandler;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskStatusWasChangedEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskWasCreatedEvent;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class ChangeTaskStatusCommandHandlerTest extends CommandHandlerScenarioTestCase
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
     * @param TaskStatus $status
     *
     * @dataProvider dataProvider
     */
    public function testChangeStatus(TaskStatus $status): void
    {
        $id = $this->uuidGenerator->generate();

        $this->scenario
            ->withAggregateId($id)
            ->given(
                [
                    new TaskWasCreatedEvent(
                        new Id($id),
                        'Test summary',
                        'Test description',
                        new DateTimeImmutable()
                    ),
                ]
            )
            ->when(new ChangeTaskStatusCommand(new Id($id), $status))
            ->then([new TaskStatusWasChangedEvent(new Id($id), $status)]);
    }

    public function dataProvider(): array
    {
        return [
            [TaskStatus::done()],
            [TaskStatus::todo()],
            [TaskStatus::open()],
        ];
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new ChangeTaskStatusCommandHandler(
            new EventSourcingRepository($eventStore, $eventBus, Task::class, new PublicConstructorAggregateFactory())
        );
    }
}
