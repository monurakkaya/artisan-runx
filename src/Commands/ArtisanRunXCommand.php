<?php

namespace Monurakkaya\ArtisanRunx\Commands;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class ArtisanRunXCommand extends Command
{
    protected $signature = 'runx {--commands=inspire}';

    protected $description = 'Run multiple Artisan commands with a single command';

    private array $summary = [
        'succeeded' => 0,
        'failed' => 0,
        'not_found' => 0
    ];

    public function handle()
    {
        $command = $this->option('commands');

        $commands = explode('&&', $command);

        foreach ($commands as $command) {
            $this->info("Running command: $command");
            try {
                $this->call(trim($command));
                $this->countSucceeded();
            } catch (CommandNotFoundException $exception) {
                $this->error($exception->getMessage());
                $this->countNotFound();
            } catch (Exception $exception) {
                $this->error($exception->getMessage());
                $this->countFailed();
            }
        }

        $this->writeSummary();

        return match ($this->hasFailed()) {
            true => Command::FAILURE,
            false => Command::SUCCESS
        };
    }

    private function countSucceeded()
    {
        $this->summary['succeeded']++;
    }

    private function countNotFound()
    {
        $this->summary['not_found']++;
        $this->countFailed();
    }

    private function countFailed()
    {
        $this->summary['failed']++;
    }

    private function hasFailed(): bool
    {
        return $this->summary['failed'] > 0;
    }

    private function writeSummary()
    {
        $this->info('Artisan RunX Summary:');
        $this->table(
            ['Success', 'Not Found', 'Failed'],
            [array_values($this->summary)],
            'box-double'
        );
    }

}
