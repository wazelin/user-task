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
use Wazelin\UserTask\Assignment\Business\Command\AssignCommand;
use Wazelin\UserTask\Assignment\Business\Command\AssignCommandHandler;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskStatusWasChangedEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasAssignedToTaskEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasUnassignedFromTaskEvent;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskWasCreatedEvent;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\User\Business\Domain\Event\UserWasCreatedEvent;
use Wazelin\UserTask\User\Business\Domain\User;

class AssignCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    private UuidGeneratorInterface $uuidGenerator;

    /**
     * @before
     */
    public function init(): void
    {
        $this->uuidGenerator = new Version4Generator();
    }

    public function testAssignTask(): void
    {
        $userWasCreatedEvent = $this->createUserWasCreatedEvent();
        $taskWasCreatedEvent = $this->createTaskWasCreatedEvent();

        $this->scenario
            ->withAggregateId((string)$userWasCreatedEvent->getId())
            ->given([$userWasCreatedEvent])
            ->withAggregateId((string)$taskWasCreatedEvent->getId())
            ->given([$taskWasCreatedEvent])
            ->when(
                new AssignCommand(
                    $userWasCreatedEvent->getId(),
                    $taskWasCreatedEvent->getId()
                )
            )
            ->then(
                [
                    new TaskStatusWasChangedEvent(
                        $taskWasCreatedEvent->getId(),
                        TaskStatus::todo()
                    ),
                    new UserWasAssignedToTaskEvent(
                        $userWasCreatedEvent->getId(),
                        $taskWasCreatedEvent->getId()
                    ),
                ]
            );
    }

    public function testReAssignTask(): void
    {
        $userWasCreatedEvent       = $this->createUserWasCreatedEvent();
        $secondUserWasCreatedEvent = $this->createUserWasCreatedEvent();
        $taskWasCreatedEvent       = $this->createTaskWasCreatedEvent();

        $userWasAssignedToTask = new UserWasAssignedToTaskEvent(
            $userWasCreatedEvent->getId(),
            $taskWasCreatedEvent->getId()
        );

        $this->scenario
            ->withAggregateId((string)$userWasCreatedEvent->getId())
            ->given([$userWasCreatedEvent])
            ->withAggregateId((string)$secondUserWasCreatedEvent->getId())
            ->given([$secondUserWasCreatedEvent])
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
                new AssignCommand(
                    $secondUserWasCreatedEvent->getId(),
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
                    new TaskStatusWasChangedEvent(
                        $taskWasCreatedEvent->getId(),
                        TaskStatus::todo()
                    ),
                    new UserWasAssignedToTaskEvent(
                        $secondUserWasCreatedEvent->getId(),
                        $taskWasCreatedEvent->getId()
                    ),
                ]
            );
    }

    public function testDoubleAssignTask(): void
    {
        $userWasCreatedEvent       = $this->createUserWasCreatedEvent();
        $taskWasCreatedEvent       = $this->createTaskWasCreatedEvent();

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
                new AssignCommand(
                    $userWasCreatedEvent->getId(),
                    $taskWasCreatedEvent->getId()
                )
            )
            ->then([]);
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new AssignCommandHandler(
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
