<?php

namespace Dash8x\Generators\Commands;


use Illuminate\Support\Str;

abstract class InstallAndReplaceCommand extends \Hesto\Core\Commands\InstallAndReplaceCommand
{
    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getParsedNameInput()
    {
        return mb_strtolower(Str::singular($this->getNameInput()));
    }

    /**
     * Check if stub's content exists in given file (path)
     *
     * @param $path
     * @param $stub
     * @return bool
     */
    public function contentExists($path, $stub)
    {
        $originalContent = $this->files->get($path);
        $content = $this->replaceNames($this->files->get($stub));

        if(Str::contains(trim($originalContent), trim($content))) {
            return true;
        }

        return false;
    }
}
