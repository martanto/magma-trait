<?php

namespace Martanto\MagmaTrait\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeTrait extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Trait.';

    /**
     * Namespace name
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get stub location
     */
    protected function getStub(): string
    {
        return base_path('stubs/trait.stub');
    }

    /**
     * Get full namespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Traits';
    }

    /**
     * Replace stub with trait name
     *
     * @return array|string|string[]
     */
    protected function replaceClass($stub, $name): array|string
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{{trait_name}}', $class, $stub);
    }
}
