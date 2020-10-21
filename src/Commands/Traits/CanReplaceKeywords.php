<?php
/**
 * Created by PhpStorm.
 * User: dash-
 * Date: 17/06/2018
 * Time: 16:48
 */

namespace Javaabu\Generators\Commands\Traits;

use Illuminate\Support\Str;

trait CanReplaceKeywords
{

    /**
     * Replace names with pattern.
     *
     * @param string $template
     * @return $this
     */
    public function replaceNames($template)
    {
        $name = $this->getParsedNameInput();

        $name = Str::snake(Str::camel(Str::plural($name)));

        $plural = [
            '{{pluralCamel}}',
            '{{pluralSlug}}',
            '{{pluralSnake}}',
            '{{pluralClass}}',
            '{{pluralTitle}}',
            '{{pluralLower}}',
            '{{pluralConstant}}',
        ];

        $singular = [
            '{{singularCamel}}',
            '{{singularSlug}}',
            '{{singularSnake}}',
            '{{singularClass}}',
            '{{singularTitle}}',
            '{{singularLower}}',
            '{{singularConstant}}',
        ];

        $replacePlural = [
            Str::camel($name),
            Str::slug($name),
            Str::snake($name),
            ucfirst(Str::camel($name)),
            Str::title(str_replace('_', ' ', $name)),
            strtolower(str_replace('_', ' ', $name)),
            strtoupper(Str::snake($name)),
        ];

        $replaceSingular = [
            Str::singular(Str::camel($name)),
            Str::singular(Str::slug($name)),
            Str::singular(Str::snake($name)),
            Str::singular(ucfirst(Str::camel($name))),
            Str::singular(Str::title(str_replace('_', ' ', $name))),
            Str::singular(strtolower(str_replace('_', ' ', $name))),
            Str::singular(strtoupper(Str::snake($name))),
        ];

        $template = str_replace($plural, $replacePlural, $template);
        $template = str_replace($singular, $replaceSingular, $template);
        $template = str_replace('{{Class}}', ucfirst(Str::camel($name)), $template);

        return $template;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getPluralClassNameInput()
    {
        $name = Str::snake(Str::camel(Str::plural($this->getParsedNameInput())));
        return ucfirst(Str::camel($name));
    }

    /**
     * Get the desired slug name from the input.
     *
     * @return string
     */
    protected function getPluralSlugNameInput()
    {
        $name = Str::snake(Str::camel(Str::plural($this->getParsedNameInput())));
        return Str::slug($name);
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getSingularClassNameInput()
    {
        return ucfirst(Str::camel(Str::singular($this->getNameInput())));
    }
}
