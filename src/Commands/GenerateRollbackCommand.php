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

        $git_reset = new Process(['git reset']);
        $git_reset->run();

        $git_checkout = new Process(['git checkout .']);
        $git_checkout->run();

        $git_clean = new Process(['git clean', '-fd']);
        $git_clean->run();

        $this->info('Generator changes rolled back');

        return Command::SUCCESS;
    }
}
