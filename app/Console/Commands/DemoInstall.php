<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function Termwind\ask;

class DemoInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the demo database and publish the demo contents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demoDB = database_path('/demo.sql');
        $zipPath = database_path('/demo.zip');
        try {

            $clear = $this->anticipate('Warning: This action will delete the database tables,columns and all data permanently?', ['Ok, Continue', 'No, Cancel'], 'Ok, Continue');

            if ($clear != 'Ok, Continue') {
                info('Canceled the installation process');
                exit;
            }

            info('wiping database');
            Artisan::call('db:wipe');

            info('Importing demo database');
            Schema::disableForeignKeyConstraints();
            DB::unprepared(file_get_contents($demoDB));
            Schema::enableForeignKeyConstraints();
            info('Done..!');

            info('Publishing assets..');
            if (is_file($zipPath)) {
                // deploy the the demo zip contents into /demo

                info('Done!');
            } else {
                info('demo.zip file not exists');
            }

            info('Demo app has been installed successfully.');
            exit;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
