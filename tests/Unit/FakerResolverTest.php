<?php

namespace Javaabu\Generators\Tests\Unit;

use Javaabu\Generators\Resolvers\FactoryResolver;
use Javaabu\Generators\Tests\InteractsWithDatabase;
use Javaabu\Generators\Tests\TestCase;

class FakerResolverTest extends TestCase
{
    use InteractsWithDatabase;

    /** @test */
    public function it_can_determine_the_faker_method_from_attribute_name(): void
    {
        $this->setupDatabase();

        $factory_resolver = new FactoryResolver('test');

        $this->assertNull($factory_resolver->getFakerMethodFromAttribute('colorful'));
        $this->assertEquals('email', $factory_resolver->getFakerMethodFromAttribute('email'));
        $this->assertEquals('firstName', $factory_resolver->getFakerMethodFromAttribute('first_name'));
    }
}
