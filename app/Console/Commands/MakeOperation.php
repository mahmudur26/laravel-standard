<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeOperation extends GeneratorCommand
{
    protected $name = 'make:operation';
    protected $description = 'Create a new Operation class';
    protected $type = 'Operation';
    protected function getStub()
    {
        return base_path('stubs/operation.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Operations';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the operation class'],
        ];
    }
}
