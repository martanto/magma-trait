<?php

namespace Martanto\MagmaTrait\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeService extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service.';

    /**
     * Namespace name
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get stub location
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../stubs/service.stub.stub';
    }

    /**
     * Get full namespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Services';
    }

    /**
     * Get the desired class name from the input.
     */
    protected function getNameInput(): string
    {
        return trim($this->argument('name')).'Service';
    }

    /**
     * Replace stub with service name
     *
     * @return array|string|string[]
     */
    protected function replaceClass($stub, $name): array|string
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{{service_name}}', $class, $stub);
    }
}
