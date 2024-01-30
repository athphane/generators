<?php

namespace Javaabu\Generators\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class StubRenderer
{
    protected Filesystem $files;

    /**
     * Constructor
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function getFileContents(string $file): string
    {
        return $this->files->get($file);
    }

    public function replaceStubNames(string $stub, string $name): string
    {
        return $this->replaceNames($name, $this->getFileContents($stub));
    }

    public function replaceNames(string $name, string $template): string
    {
        $plural_name = Str::of($name)
                    ->plural()
                    ->camel()
                    ->snake();

        $singular_name = $plural_name->singular();

        $plural = [
            '{{pluralCamel}}',
            '{{pluralSlug}}',
            '{{pluralSnake}}',
            '{{pluralStudly}}',
            '{{pluralTitle}}',
            '{{pluralLower}}',
        ];

        $singular = [
            '{{singularCamel}}',
            '{{singularSlug}}',
            '{{singularSnake}}',
            '{{singularStudly}}',
            '{{singularTitle}}',
            '{{singularLower}}',
        ];

        $replacePlural = [
            $plural_name->camel()->toString(),
            $plural_name->slug()->toString(),
            $plural_name->snake()->toString(),
            $plural_name->studly()->toString(),
            $plural_name->replace('_', ' ')->title()->toString(),
            $plural_name->replace('_', ' ')->lower()->toString(),
        ];

        $replaceSingular = [
            $singular_name->camel()->toString(),
            $singular_name->slug()->toString(),
            $singular_name->snake()->toString(),
            $singular_name->studly()->toString(),
            $singular_name->replace('_', ' ')->title()->toString(),
            $singular_name->replace('_', ' ')->lower()->toString(),
        ];

        $template = str_replace($plural, $replacePlural, $template);
        $template = str_replace($singular, $replaceSingular, $template);

        return $template;
    }
}
