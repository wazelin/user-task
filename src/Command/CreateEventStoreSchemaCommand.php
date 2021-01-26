<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Command;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateEventStoreSchemaCommand extends Command
{
    public function __construct(private Connection $connection, private DBALEventStore $eventStore)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('persistence:event-store:create')
            ->setDescription('Creates the event store schema')
            ->setHelp(
                <<<HELP
                    The <info>%command.name%</info> command creates the schema in the default
                    connections database:
                    <info>php app/console %command.name%</info>
                HELP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaManager = $this->connection->getSchemaManager();

        if ($table = $this->eventStore->configureSchema($schemaManager->createSchema())) {
            $schemaManager->createTable($table);
            $output->writeln('<info>Created Broadway event store schema</info>');
        } else {
            $output->writeln('<warning>Broadway event store schema already exists</warning>');
        }

        return Command::SUCCESS;
    }
}
