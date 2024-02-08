<?php

namespace Javaabu\Generators\Support;

use Illuminate\Support\Stringable;
use Illuminate\Support\Str;

abstract class StringCaser
{
    public static function str(string $name): Stringable
    {
        return Str::of($name)
            ->camel()
            ->snake();
    }

    public static function pluralStr(string $name): Stringable
    {
        return self::str($name)->plural();
    }

    public static function singularStr(string $name): Stringable
    {
        return self::str($name)->singular();
    }

    public static function pluralCamel(string $name): string
    {
        return self::pluralStr($name)->camel()->toString();
    }

    public static function pluralKebab(string $name): string
    {
        return self::pluralStr($name)->slug()->toString();
    }

    public static function pluralSnake(string $name): string
    {
        return self::pluralStr($name)->snake()->toString();
    }

    public static function pluralStudly(string $name): string
    {
        return self::pluralStr($name)->studly()->toString();
    }

    public static function pluralTitle(string $name): string
    {
        return self::pluralStr($name)->replace('_', ' ')->title()->toString();
    }

    public static function pluralLower(string $name): string
    {
        return self::pluralStr($name)->replace('_', ' ')->lower()->toString();
    }

    public static function singularCamel(string $name): string
    {
        return self::singularStr($name)->camel()->toString();
    }

    public static function singularKebab(string $name): string
    {
        return self::singularStr($name)->slug()->toString();
    }

    public static function singularSnake(string $name): string
    {
        return self::singularStr($name)->snake()->toString();
    }

    public static function singularStudly(string $name): string
    {
        return self::singularStr($name)->studly()->toString();
    }

    public static function singularTitle(string $name): string
    {
        return self::singularStr($name)->replace('_', ' ')->title()->toString();
    }

    public static function singularLower(string $name): string
    {
        return self::singularStr($name)->replace('_', ' ')->lower()->toString();
    }

    public static function camel(string $name): string
    {
        return self::str($name)->camel()->toString();
    }

    public static function kebab(string $name): string
    {
        return self::str($name)->slug()->toString();
    }

    public static function snake(string $name): string
    {
        return self::str($name)->snake()->toString();
    }

    public static function studly(string $name): string
    {
        return self::str($name)->studly()->toString();
    }

    public static function title(string $name): string
    {
        return self::str($name)->replace('_', ' ')->title()->toString();
    }

    public static function lower(string $name): string
    {
        return self::str($name)->replace('_', ' ')->lower()->toString();
    }

}
