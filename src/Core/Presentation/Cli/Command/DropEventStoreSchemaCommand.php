<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Cli\Command;

use Broadway\EventStore\EventStore;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropEventStoreSchemaCommand extends Command
{
    public function __construct(private Connection $connection, private EventStore $eventStore)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('core:persistence:event-store:drop')
            ->setDescription('Drops the event store schema')
            ->setHelp(
                <<<HELP
                    The <info>%command.name%</info> command drops the schema in the default
                    connections database:
                    <info>php app/console %command.name%</info>
                HELP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaManager = $this->connection->getSchemaManager();
        $table         = $this->eventStore->configureTable(new Schema());

        if ($schemaManager->tablesExist([$table->getName()])) {
            $schemaManager->dropTable($table->getName());
            $output->writeln('<info>Dropped Broadway event-store schema</info>');
        } else {
            $output->writeln('<info>Broadway event-store schema does not exist</info>');
        }

        return Command::SUCCESS;
    }
}
