<?php

namespace Javaabu\Generators\Generators\Concerns;

trait GeneratesPolicy
{
    protected function getPolicyStub(): string
    {
        return 'generators::Policies/Model' . ($this->hasSoftDeletes() ? 'SoftDeletes' : '') . 'Policy.stub';
    }

    protected function getAdditionalPolicyMethodsStub(): string
    {
        return property_exists($this, 'additional_policy_methods_stub') ? $this->additional_policy_methods_stub : '';
    }

    protected function renderAdditionalPolicyMethods(): string
    {
        if ($stub = $this->getAdditionalPolicyMethodsStub()) {
            $renderer = $this->getRenderer();

            return $renderer->replaceStubNames($stub, $this->getTable());
        }

        return '';
    }

    /**
     * Render the policy
     */
    public function renderPolicy(): string
    {
        $stub = $this->getPolicyStub();

        $renderer = $this->getRenderer();

        $template = $renderer->replaceStubNames($stub, $this->getTable());

        return $renderer->appendMultipleContent([
            [
                'search' => $renderer->addIndentation("// additional policy methods\n", 1),
                'keep_search' => false,
                'content' => $this->renderAdditionalPolicyMethods(),
            ],
        ], $template);
    }
}
