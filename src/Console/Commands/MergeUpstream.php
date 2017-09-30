<?php

namespace ElfSundae\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class MergeUpstream extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:merge-upstream
        {branch=master : git branch of upstream}
        {--remote=upstream : git remote name of upstream}
        {--force : Force the operation to run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge upstream into the current branch';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $branch = $this->argument('branch');
        $remote = $this->option('remote');

        $this->executeShell('git status');

        if (! $this->confirmToProceed("Will merge $remote/$branch into the current branch", true)) {
            return;
        }

        $commands = [
            "git fetch $remote --no-tags -v",
            "git merge $remote/$branch",
        ];

        foreach ($commands as $cmd) {
            $this->executeShell($cmd);
        }
    }

    /**
     * Execute shell command and output the result.
     *
     * @param  string  $cmd
     * @return void
     */
    protected function executeShell($cmd)
    {
        $this->comment('$ '.$cmd);

        $this->info(shell_exec($cmd));
    }
}
