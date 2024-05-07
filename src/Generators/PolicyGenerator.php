<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Generators\Concerns\GeneratesPolicy;

class PolicyGenerator extends BaseGenerator
{
    use GeneratesPolicy;

    /**
     * Render the policy
     */
    public function render(): string
    {
        return $this->renderPolicy();
    }
}
