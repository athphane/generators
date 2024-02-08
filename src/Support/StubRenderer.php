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

    public function replaceStubNames(string $stub, string $name, string $suffix = ''): string
    {
        return $this->replaceFileNames($this->resolveStubPath($stub), $name, $suffix);
    }

    public function replaceFileNames(string $stub, string $name, string $suffix = ''): string
    {
        return $this->replaceNames($name, $this->getFileContents($stub), $suffix);
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
        return $this->appendToFile($this->resolveStubPath($stub), $content, $search, $keep_search);
    }

    public function appendToFile(string $stub, string $content, string $search, bool $keep_search = true): string
    {
        return $this->appendContent($content, $search, $this->getFileContents($stub), $keep_search);
    }

    public function appendContent(string $content, string $search, string $template, bool $keep_search = true): string
    {
        $insertion = $keep_search ? $search . $content : $content;

        return str_replace($search, $insertion, $template);
    }

    public function appendMultipleContent(array $contents, string $template, bool $skip_existing = false): string
    {
        foreach ($contents as $setting) {
            $content = $setting['content'] ?? '';
            $search = $setting['search'] ?? '';
            $keep_search = $setting['keep_search'] ?? false;

            if ($skip_existing && Str::contains($template, $content)) {
                continue;
            }

            $template = $this->appendContent(
                $content,
                $search,
                $template,
                $keep_search
            );
        }

        return $template;
    }

    public function addIndentation(string $content, int $count, int $tab_spaces = 4, string $space = ' '): string
    {
        $spaces = $count * $tab_spaces;

        return Str::repeat($space, $spaces) . $content;
    }

    public function replaceNames(string $name, string $template, string $suffix = ''): string
    {
        $plural = [
            "{{pluralCamel$suffix}}",
            "{{pluralKebab$suffix}}",
            "{{pluralSnake$suffix}}",
            "{{pluralStudly$suffix}}",
            "{{pluralTitle$suffix}}",
            "{{pluralLower$suffix}}",
        ];

        $singular = [
            "{{singularCamel$suffix}}",
            "{{singularKebab$suffix}}",
            "{{singularSnake$suffix}}",
            "{{singularStudly$suffix}}",
            "{{singularTitle$suffix}}",
            "{{singularLower$suffix}}",
        ];

        $replacePlural = [
            StringCaser::pluralCamel($name),
            StringCaser::pluralKebab($name),
            StringCaser::pluralSnake($name),
            StringCaser::pluralStudly($name),
            StringCaser::pluralTitle($name),
            StringCaser::pluralLower($name),
        ];

        $replaceSingular = [
            StringCaser::singularCamel($name),
            StringCaser::singularKebab($name),
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
