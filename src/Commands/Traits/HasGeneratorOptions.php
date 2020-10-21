<?php
/**
 * Created by PhpStorm.
 * User: dash-
 * Date: 17/06/2018
 * Time: 16:48
 */

namespace Javaabu\Generators\Commands\Traits;

use Symfony\Component\Console\Input\InputOption;

trait HasGeneratorOptions
{

    /**
     * Check if using soft deletes
     *
     * @return boolean
     */
    protected function softDeletes()
    {
        return $this->option('soft_deletes') == true;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force override existing files'],
            ['soft_deletes', 's', InputOption::VALUE_NONE, 'Enable soft deletes'],
        ];
    }
}