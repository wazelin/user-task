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
use DateTimeInterface;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Command\CreateTaskCommand;
use Wazelin\UserTask\Task\Business\Command\CreateTaskCommandHandler;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\TaskEvent\TaskWasCreatedEvent;

class CreateTaskCommandHandlerTest extends CommandHandlerScenarioTestCase
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
     * @param string $summary
     * @param string $description
     * @param ?DateTimeInterface $dueDate
     *
     * @dataProvider dataProvider
     */
    public function testCreateNewTask(string $summary, string $description, DateTimeInterface $dueDate = null): void
    {
        $id = $this->uuidGenerator->generate();

        $this->scenario
            ->withAggregateId($id)
            ->when(new CreateTaskCommand(new Id($id), $summary, $description, $dueDate))
            ->then([new TaskWasCreatedEvent(new Id($id), $summary, $description, $dueDate)]);
    }

    public function dataProvider(): array
    {
        return [
            'All properties'            => [
                'summary'     => 'summary_1',
                'description' => 'description_1',
                'dueDate'     => new DateTimeImmutable('1970-01-01'),
            ],
            'Without optional due date' => [
                'summary'     => 'summary_2',
                'description' => 'description_2',
            ],
        ];
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new CreateTaskCommandHandler(
            new EventSourcingRepository($eventStore, $eventBus, Task::class, new PublicConstructorAggregateFactory())
        );
    }
}
