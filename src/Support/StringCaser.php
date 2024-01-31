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

    public static function pluralSlug(string $name): string
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

    public static function singularSlug(string $name): string
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

}
