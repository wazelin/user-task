<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests\Unit\Assignment\Command;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use DateTimeImmutable;
use Wazelin\UserTask\Assignment\Business\Command\UnassignCommand;
use Wazelin\UserTask\Assignment\Business\Command\UnassignCommandHandler;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskStatusWasChangedEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasAssignedToTaskEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasUnassignedFromTaskEvent;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskWasCreatedEvent;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\User\Business\Domain\Event\UserWasCreatedEvent;
use Wazelin\UserTask\User\Business\Domain\User;

class UnassignCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    private UuidGeneratorInterface $uuidGenerator;

    /**
     * @before
     */
    public function init(): void
    {
        $this->uuidGenerator = new Version4Generator();
    }

    public function testUnassignTask(): void
    {
        $userWasCreatedEvent = $this->createUserWasCreatedEvent();
        $taskWasCreatedEvent = $this->createTaskWasCreatedEvent();

        $userWasAssignedToTask = new UserWasAssignedToTaskEvent(
            $userWasCreatedEvent->getId(),
            $taskWasCreatedEvent->getId()
        );

        $this->scenario
            ->withAggregateId((string)$userWasCreatedEvent->getId())
            ->given([$userWasCreatedEvent])
            ->withAggregateId((string)$taskWasCreatedEvent->getId())
            ->given(
                [
                    $taskWasCreatedEvent,
                    new TaskStatusWasChangedEvent(
                        $taskWasCreatedEvent->getId(),
                        TaskStatus::todo()
                    ),
                    $userWasAssignedToTask,
                ]
            )
            ->when(
                new UnassignCommand(
                    $userWasCreatedEvent->getId(),
                    $taskWasCreatedEvent->getId()
                )
            )
            ->then(
                [
                    new UserWasUnassignedFromTaskEvent(
                        $userWasCreatedEvent->getId(),
                        $taskWasCreatedEvent->getId()
                    ),
                    new TaskStatusWasChangedEvent(
                        $taskWasCreatedEvent->getId(),
                        TaskStatus::open()
                    ),
                ]
            );
    }

    public function testDoubleUnassignTask(): void
    {
        $userWasCreatedEvent = $this->createUserWasCreatedEvent();
        $taskWasCreatedEvent = $this->createTaskWasCreatedEvent();

        $userWasAssignedToTask          = new UserWasAssignedToTaskEvent(
            $userWasCreatedEvent->getId(),
            $taskWasCreatedEvent->getId()
        );
        $userWasUnassignedFromTaskEvent = new UserWasUnassignedFromTaskEvent(
            $userWasCreatedEvent->getId(),
            $taskWasCreatedEvent->getId()
        );

        $this->scenario
            ->withAggregateId((string)$userWasCreatedEvent->getId())
            ->given([$userWasCreatedEvent])
            ->withAggregateId((string)$taskWasCreatedEvent->getId())
            ->given(
                [
                    $taskWasCreatedEvent,
                    new TaskStatusWasChangedEvent(
                        $taskWasCreatedEvent->getId(),
                        TaskStatus::todo()
                    ),
                    $userWasAssignedToTask,
                    $userWasUnassignedFromTaskEvent,
                    new TaskStatusWasChangedEvent(
                        $taskWasCreatedEvent->getId(),
                        TaskStatus::open()
                    )
                ]
            )
            ->when(
                new UnassignCommand(
                    $userWasCreatedEvent->getId(),
                    $taskWasCreatedEvent->getId()
                )
            )
            ->then([]);
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new UnassignCommandHandler(
            new EventSourcingRepository($eventStore, $eventBus, User::class, new PublicConstructorAggregateFactory()),
            new EventSourcingRepository($eventStore, $eventBus, Task::class, new PublicConstructorAggregateFactory())
        );
    }

    private function createUserWasCreatedEvent(): UserWasCreatedEvent
    {
        return new UserWasCreatedEvent(
            $this->createDomainId(),
            'Test user'
        );
    }

    private function createTaskWasCreatedEvent(): TaskWasCreatedEvent
    {
        return new TaskWasCreatedEvent(
            $this->createDomainId(),
            'Test task',
            'A test task, nothing to see here.',
            new DateTimeImmutable()
        );
    }

    private function createDomainId(): Id
    {
        return new Id(
            $this->uuidGenerator->generate()
        );
    }
}
