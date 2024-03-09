<?php

namespace Javaabu\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Javaabu\Generators\Exceptions\ColumnDoesNotExistException;
use Javaabu\Generators\Exceptions\MultipleTablesSuppliedException;
use Javaabu\Generators\Exceptions\TableDoesNotExistException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GenerateRollbackCommand extends Command
{
    use ConfirmableTrait;

    protected $name = 'generate:rollback';

    protected $description = 'Rolls back changes after running a generate command.';


    /** @return array */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Runs the command without any user prompts'],
        ];
    }

    /**
     * @throws BindingResolutionException
     * @throws MultipleTablesSuppliedException
     * @throws TableDoesNotExistException
     * @throws ColumnDoesNotExistException
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed('If you run this command, you will lose all uncommitted changes!', true)) {
            return 0;
        }

        $commands = [
            ['git', 'reset'],
            ['git', 'checkout', '.'],
            ['git', 'clean', '-fd']
        ];

        $this->runCommands($commands);

        $this->info('Generator changes rolled back');

        return Command::SUCCESS;
    }

    protected function runCommands(array $commands): void
    {
        foreach ($commands as $command_args) {
            $command = new Process($command_args);
            $command->run();

            // executes after the command finishes
            if (! $command->isSuccessful()) {
                throw new ProcessFailedException($command);
            }

            $this->info($command->getOutput());
        }
    }
}
