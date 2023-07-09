<?php

namespace Monurakkaya\ArtisanRunx\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ArtisanRunXCommand extends Command
{
    protected $signature = 'runx {--commands=inspire}';

    protected $description = 'Run multiple Artisan commands with a single command';

    private array $summary = [
        'succeeded' => 0,
        'failed' => 0,
    ];

    public function handle()
    {
        $command = $this->option('commands');

        $commands = explode('&&', $command);

        foreach ($commands as $command) {

            $this->info("Running command: $command");
            try {
                $re = '/(\\\\+)[a-zA-Z0-9]*/m';
                preg_match_all($re, $command, $matches, PREG_SET_ORDER, 0);

                foreach ($matches as $match) {
                    $command = str_replace($match[1], '\\\\\\', $command);
                }

                $result = Process::run("php artisan ${command}", function (string $type, string $output) {
                    $this->info($output);
                });

                $result->successful()
                    ? $this->countSucceeded()
                    : $this->countFailed();
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
            ['Success', 'Failed'],
            [array_values($this->summary)],
            'box-double'
        );
    }
}
