<?php

namespace Javaabu\Generators\Tests\Unit\Generators;

use Javaabu\Generators\Generators\ExportGenerator;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class ExportGeneratorTest extends TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_generate_an_export(): void
    {
        $export_generator = new ExportGenerator('categories');

        $expected_content = $this->getTestStubContents('Exports/CategoriesExport.php');
        $actual_content = $export_generator->render();

        $this->assertEquals($expected_content, $actual_content);
    }
}
