<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new helper class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!File::isDirectory(app_path('Helpers'))) {
            File::makeDirectory(app_path('Helpers'));
        }

        $name = $this->argument('name');
        $helperPath = app_path("Helpers/{$name}.php");

        if (File::exists($helperPath)) {
            $this->error('Helper already exists!');
            return;
        }

        $helperTemplate = <<<"template"
        <?php

        namespace App\Helpers;

        class {$name}
        {
            //
        }
        template;

        File::put($helperPath, $helperTemplate);

        $this->info("Helper {$name} created successfully!");
    }
}
