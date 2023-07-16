<?php

namespace Monurakkaya\ArtisanRunx\Tests;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class InspireCommand extends Command
{
    protected $signature = 'inspire';

    public function handle()
    {
        $this->comment(Inspiring::quote());

        return Command::SUCCESS;
    }
}
