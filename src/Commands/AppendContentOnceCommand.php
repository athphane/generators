<?php

namespace Dash8x\Generators\Commands;

use Dash8x\Generators\Commands\Traits\CanReplaceKeywords;
use Illuminate\Support\Str;


abstract class AppendContentOnceCommand extends AppendContentCommand
{
    use CanReplaceKeywords;

    /**
     * Compile content.
     *
     * @param $path
     * @param $setting
     * @return mixed
     */
    protected function compileContent($path, $setting) //It should be compile method instead
    {
        $originalContent = $this->files->get($path);
        $content = $this->replaceNames($this->files->get($setting['stub']));

        if( ! Str::contains(trim($originalContent), trim($content))) {

            $last_occurence = false;
            if ($setting['prefix']) {
                $stub = $content . $setting['search'];
                $last_occurence = true;
            } else {
                $stub = $setting['search'] . $content;
            }

            $originalContent = $this->str_replace_once($setting['search'], $stub, $originalContent, $last_occurence);
        }

        return $originalContent;
    }

    /**
     * Replace one occurence
     */
    public function str_replace_once($needle, $replace, $haystack, $last_occurence = false)
    {
        $pos = $last_occurence ? strrpos($haystack, $needle) : strpos($haystack, $needle);
        if ($pos !== false) {
            return substr_replace($haystack, $replace, $pos, strlen($needle));
        }
        return $haystack;
    }
}
