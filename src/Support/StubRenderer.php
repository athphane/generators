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

    public function loadStub(string $stub): string
    {
        return $this->getFileContents($this->resolveStubPath($stub));
    }

    public function resolveStubPath(string $stub): string
    {
        $package = Str::before($stub, '::');
        $stub_name = trim(Str::after($stub, '::'), '/');

        $custom_path = base_path('stubs/' . $package . '/' . $stub_name);

        return file_exists($custom_path) ? $custom_path : $this->defaultStubPath() . '/' . $stub_name;
    }

    public function defaultStubPath(): string
    {
        return __DIR__ . '/../../stubs';
    }

    public function appendToStub(string $stub, string $content, string $search, bool $keep_search = true): string
    {
        return $this->appendContent($content, $search, $this->getFileContents($stub), $keep_search);
    }

    public function appendContent(string $content, string $search, string $template, bool $keep_search = true): string
    {
        $insertion = $keep_search ? $search . $content : $content;

        return str_replace($search, $insertion, $template);
    }

    public function replaceNames(string $name, string $template): string
    {
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
            StringCaser::pluralCamel($name),
            StringCaser::pluralSlug($name),
            StringCaser::pluralSnake($name),
            StringCaser::pluralStudly($name),
            StringCaser::pluralTitle($name),
            StringCaser::pluralLower($name),
        ];

        $replaceSingular = [
            StringCaser::singularCamel($name),
            StringCaser::singularSlug($name),
            StringCaser::singularSnake($name),
            StringCaser::singularStudly($name),
            StringCaser::singularTitle($name),
            StringCaser::singularLower($name),
        ];

        $template = str_replace($plural, $replacePlural, $template);
        $template = str_replace($singular, $replaceSingular, $template);

        return $template;
    }
}
