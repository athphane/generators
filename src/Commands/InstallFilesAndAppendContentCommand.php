<?php

namespace Javaabu\Generators\Commands;

use Javaabu\Generators\Commands\Traits\CanReplaceKeywords;
use SplFileInfo;


abstract class InstallFilesAndAppendContentCommand extends AppendContentCommand
{
    use CanReplaceKeywords;

    /**
     * Get the destination path.
     *
     * @return array
     */
    abstract function getFiles();

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $files = $this->getFiles();

        foreach ($files as $file) {
            $path = $file['path'];
            $fullPath = base_path() . $path;

            $fileObject = new SplFileInfo($file['stub']);

            if($this->putFile($fullPath, $fileObject)) {
                $this->getInfoMessage($fullPath);
            }
        }

        $settings = $this->getSettings();

        foreach ($settings as $setting) {
            $path = $setting['path'];
            $fullPath = base_path() . $path;

            if ($this->putContent($fullPath, $this->compileContent($fullPath, $setting))) {
                $this->getInfoMessage($fullPath);
            }

        }

        return true;
    }
}
