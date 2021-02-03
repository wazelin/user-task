<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Cli\Command;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Broadway\EventStore\EventVisitor;
use Broadway\EventStore\Management\Criteria;
use Broadway\EventStore\Management\EventStoreManagement;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReplayEventsCommand extends Command implements EventVisitor
{
    private OutputInterface $output;
    /**
     * @var EventListener[]
     */
    private iterable $eventListeners;

    /**
     * @param EventStoreManagement $eventStoreManager
     * @param EventListener[] $eventListeners
     */
    public function __construct(private EventStoreManagement $eventStoreManager, iterable $eventListeners)
    {
        parent::__construct();

        $this->eventListeners = $eventListeners;
    }

    public function doWithEvent(DomainMessage $domainMessage): void
    {
        $this->output->writeln(
            sprintf(
                'Visiting <info>%s</info> of aggregate root <info>#%s</info>/<comment>%s</comment>, recorded on <comment>%s</comment>',
                $domainMessage->getType(),
                $domainMessage->getId(),
                $domainMessage->getPlayhead(),
                $domainMessage->getRecordedOn()->toString()
            )
        );

        foreach ($this->eventListeners as $eventListener) {
            $eventListener->handle($domainMessage);
        }
    }

    protected function configure(): void
    {
        $this
            ->setName('core:persistence:event-store:replay')
            ->setDescription('Replays all the events in order to rebuild the projections.')
            ->setHelp(
                <<<HELP
                    The <info>%command.name%</info> replays all the events in order to rebuild the projections
                    <info>php app/console %command.name%</info>
                HELP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;

        try {
            $this->eventStoreManager->visitEvents(
                Criteria::create(),
                $this
            );
        } catch (Exception) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
