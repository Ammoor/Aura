<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    private string $appName;
    public function __construct()
    {
        $this->appName = config('app.name');
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $localPath = public_path('storage/profile-images/default_profile_image.jpg');
        $s3Path = "{$this->appName}/profile-images/default_profile_image.jpg";
        if (!Storage::disk('s3')->exists($s3Path)) {

            Storage::disk('s3')->put($s3Path, file_get_contents($localPath), 'public');
        }
    }
}
