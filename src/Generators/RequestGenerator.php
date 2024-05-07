<?php

namespace Javaabu\Generators\Generators;

use Javaabu\Generators\Generators\Concerns\GeneratesRequest;

class RequestGenerator extends BaseGenerator
{
    use GeneratesRequest;

    protected string $request_stub = 'generators::Requests/ModelRequest.stub';

    /**
     * Render the request
     */
    public function render(): string
    {
        return $this->renderRequest();
    }
}
