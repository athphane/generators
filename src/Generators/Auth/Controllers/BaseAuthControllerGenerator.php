<?php

namespace Javaabu\Generators\Generators\Auth\Controllers;

use Javaabu\Generators\Generators\Auth\BaseAuthGenerator;

abstract class BaseAuthControllerGenerator extends BaseAuthGenerator
{
    public abstract function getControllerName(): string;

    public abstract function getControllerPath(): string;
}
