<?php

namespace ElfSundae\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;

class AssetsVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:assets-version
        {--filename=assets-version : The filename of the assets version configuration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update assets version configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = (string) $this->option('filename');

        $assets = $this->laravel['config']->get($filename);

        $revisioned = $this->revisionAssets($assets);

        if ($assets !== $revisioned) {
            $this->updateAssetsVersionConfigFile($filename, $revisioned);

            $this->laravel['config'][$filename] = $revisioned;
        }

        $this->info('Assets version configuration'.
            ' <comment>'.$this->getConfigFilePath($filename).'</comment> '.
            (is_null($assets) ? 'created!' : 'updated!'));
    }

    /**
     * Revision assets.
     *
     * @param  array|null  $assets
     * @return array
     */
    protected function revisionAssets($assets)
    {
        $newAssets = [];

        if (is_array($assets)) {
            foreach ($assets as $filename => $value) {
                if (is_numeric($filename)) {
                    $filename = $value;
                    $value = '0';
                }

                $filename = trim($filename, DIRECTORY_SEPARATOR);

                $path = public_path($filename);

                if (is_file($path)) {
                    $value = substr(md5_file($path), 0, 10);
                } else {
                    $this->error("Revisioning file [{$filename}] failed.");
                }

                $newAssets[$filename] = $value;
            }
        }

        return $newAssets;
    }

    /**
     * Update assets version config file.
     *
     * @param  string  $filename
     * @param  mixed  $assets
     */
    protected function updateAssetsVersionConfigFile($filename, $assets)
    {
        file_put_contents(
            $this->getConfigFilePath($filename),
            sprintf("<?php\n\nreturn %s;\n", var_export($assets, true))
        );
    }

    /**
     * Get config file path.
     *
     * @param  string  $filename
     * @return string
     */
    protected function getConfigFilePath($filename)
    {
        return config_path($filename.'.php');
    }
}
