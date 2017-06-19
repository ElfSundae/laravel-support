<?php

namespace ElfSundae\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;

class GenerateIdeHelpers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:generate-ide-helpers
        {--alone : Do not execute clear-compiled and optimize commands}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new IDE Helper files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->option('alone')) {
            $this->call('clear-compiled');
        }

        if ($this->laravel->bound('command.ide-helper.generate')) {
            $this->call('ide-helper:generate');
            $this->call('ide-helper:meta');
            $this->call('ide-helper:models', ['-R' => true, '-N' => true]);
        }

        if (! $this->option('alone')) {
            $this->call('optimize');
        }
    }
}
