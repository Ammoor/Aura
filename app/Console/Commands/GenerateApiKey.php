<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a secure API key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = Str::random(64);
        $this->info("Generated API Key:\n\n{$key}");
    }
}
