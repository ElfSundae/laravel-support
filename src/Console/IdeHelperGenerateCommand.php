<?php

namespace ElfSundae\Laravel\Support\Console;

use Illuminate\Console\Command;

class IdeHelperGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:ide-helper-generate
        {--s|standalone : Do not call "clear-compiled" command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new IDE helper files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->option('standalone')) {
            $this->call('clear-compiled');
        }

        if ($this->laravel->bound('command.ide-helper.generate')) {
            $this->call('ide-helper:generate');
            $this->call('ide-helper:meta');
            $this->call('ide-helper:models', ['-N' => true]);
        }
    }
}
