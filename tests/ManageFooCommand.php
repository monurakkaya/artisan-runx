<?php

namespace Monurakkaya\ArtisanRunx\Tests;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class ManageFooCommand extends Command
{
    protected $signature = 'manage-foo {action} {--id=}';

    public function handle()
    {
        match ($this->argument('action')) {
            'create' => Foo::create(),
            'delete' => Foo::where('id', $this->option('id'))->delete(),
            default => $this->error('Invalid action!')
        };

        return in_array($this->argument('action'), ['create', 'delete'])
            ? Command::SUCCESS
            : Command::FAILURE;
    }

    protected function getOptions()
    {
        return $this->argument('action') === 'delete'
            ? [
                'id' => new InputOption('id', InputOption::VALUE_REQUIRED),
            ] : [];
    }
}
