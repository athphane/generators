<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\Support\StubRenderer;
use Javaabu\Generators\Tests\TestCase;

class StubRendererTest extends TestCase
{
    /** @test */
    public function it_can_replace_single_names(): void
    {
        $renderer = $this->getRenderer();

        $expected_content = $renderer->getFileContents($this->getStubPath('SingleNameCases.php'));
        $actual_content = $renderer->replaceStubNames($this->getStubPath('NameCases.stub'), 'category');

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_replace_multiple_names(): void
    {
        $renderer = $this->getRenderer();

        $expected_content = $renderer->getFileContents($this->getStubPath('MultipleNameCases.php'));
        $actual_content = $renderer->replaceStubNames($this->getStubPath('NameCases.stub'), 'form_input_field');

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_replace_multiple_names_in_studly_format(): void
    {
        $renderer = $this->getRenderer();

        $expected_content = $renderer->getFileContents($this->getStubPath('MultipleNameCases.php'));
        $actual_content = $renderer->replaceStubNames($this->getStubPath('NameCases.stub'), 'FormInputField');

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_replace_multiple_names_in_camel_format(): void
    {
        $renderer = $this->getRenderer();

        $expected_content = $renderer->getFileContents($this->getStubPath('MultipleNameCases.php'));
        $actual_content = $renderer->replaceStubNames($this->getStubPath('NameCases.stub'), 'formInputField');

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_append_to_a_stub_without_removing_marker(): void
    {
        $renderer = $this->getRenderer();

        $expected_content = $renderer->getFileContents($this->getStubPath('AfterAppend.php'));
        $actual_content = $renderer->appendToStub($this->getStubPath('BeforeAppend.php'), "    'product',\n", "// append here - DONOT REMOVE\n");

        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_can_append_to_a_stub_with_removing_marker(): void
    {
        $renderer = $this->getRenderer();

        $expected_content = $renderer->getFileContents($this->getStubPath('AfterAppendMarkerRemoved.php'));
        $actual_content = $renderer->appendToStub($this->getStubPath('BeforeAppend.php'), "'product',\n", "// append here - DONOT REMOVE\n", false);

        $this->assertEquals($expected_content, $actual_content);
    }

    protected function getRenderer(): StubRenderer
    {
        return $this->app->make(StubRenderer::class);
    }

    protected function getStubPath(string $name): string
    {
        return __DIR__ . '/../stubs/' . $name;
    }

}
