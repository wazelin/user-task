<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Cli\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wazelin\UserTask\User\Contract\IndexableRepository;

class CreateIndicesCommand extends Command
{
    private array $repositories;

    public function __construct(IndexableRepository ...$repositories)
    {
        parent::__construct();

        $this->repositories = $repositories;
    }

    protected function configure(): void
    {
        $this
            ->setName('core:persistence:read-model:create-indices')
            ->setDescription('Creates the read model indices.')
            ->setHelp(
                <<<HELP
                    The <info>%command.name%</info> command creates the indices in the read model repositories:
                    <info>php app/console %command.name%</info>
                HELP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = Command::SUCCESS;

        foreach ($this->repositories as $repository) {
            try {
                $repository->dropIndices();
            } catch (Exception) {
            }

            if (!$repository->createIndices()) {
                $result = Command::FAILURE;
            }
        }

        return $result;
    }
}
