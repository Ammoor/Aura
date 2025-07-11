<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class S3MediaHelper
{
    public static function store(UploadedFile $media, string $mediaPath, string $disk = 'public')
    {
        if (!Storage::disk('s3')->exists($mediaPath)) {

            return Storage::disk('s3')->put($mediaPath, file_get_contents($media), $disk);
        }
    }
    public static function update(UploadedFile $media, string $oldMediaPath, string $newMediaPath)
    {
        if ($oldMediaPath !== 'profile-images/default_profile_image.jpg') {

            self::delete($oldMediaPath);
        }
        return self::store($media, $newMediaPath);
    }
    public static function delete(string $mediaPath)
    {
        if (Storage::disk('s3')->exists($mediaPath)) {
            return Storage::disk('s3')->delete($mediaPath);
        }
        return true; // If file doesn't exist, consider it deleted.
    }
    public static function getDirectoryFiles(string $directory)
    {
        return Storage::disk('s3')->allFiles($directory);
    }
    public static function deleteDirectoryFiles(string $directory)
    {
        $directoryFiles = self::getDirectoryFiles($directory);
        return Storage::disk('s3')->delete($directoryFiles);
    }
    public static function getBucketFiles()
    {
        return Storage::disk('s3')->allFiles();
    }
}
