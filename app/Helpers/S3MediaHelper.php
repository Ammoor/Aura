<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class S3MediaHelper
{
    public static function store(UploadedFile $media, string $directory)
    {
        $appName = config('app.name');
        $name = time() . '_' . uniqid() . '.' . $media->getClientOriginalExtension();
        $path = "{$appName}/{$directory}/{$name}";
        Storage::disk('s3')->put($path, file_get_contents($media));
        return $path;
    }
    public static function update(UploadedFile $media, string $oldMediaPath, string $directory)
    {
        self::delete($oldMediaPath);
        return self::store($media, $directory);
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
