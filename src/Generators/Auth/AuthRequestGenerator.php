<?php

namespace Javaabu\Generators\Generators\Auth;

use Javaabu\Generators\Generators\Concerns\GeneratesRequest;

class AuthRequestGenerator extends BaseAuthGenerator
{
    use GeneratesRequest;

    protected string $request_stub = 'generators::Requests/AuthModelRequest.stub';

    public function renderBaseRulesStatement(): string
    {
        if ((! $this->requiresEmail()) || (! $this->requiresPassword())) {
            $password = $this->requiresPassword() ? 'true' : 'false';
            $email = $this->requiresEmail() ? 'true' : 'false';

            return "\$this->baseRules($password, $email)";
        }

        return '$this->baseRules()';
    }

    protected function getRequestRulesBodyStub(): string
    {
        if (! $this->hasAdditionalAttributes()) {
            return 'generators::Requests/_authBlankRulesBody.stub';
        }

        return 'generators::Requests/_authRulesBody.stub';
    }

    /**
     * Render the request
     */
    public function render(): string
    {
        $template = $this->renderRequest();

        $renderer = $this->getRenderer();

        $template = $renderer->replaceNames($this->getAuthName(), $template, 'AuthName');

        return $renderer->appendMultipleContent([
            [
                'search' => '{{baseRule}}',
                'keep_search' => false,
                'content' => $this->renderBaseRulesStatement(),
            ],
        ], $template);
    }
}
