<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaHelper
{
    public static function store(UploadedFile $media, string $directory, string $disk = 'public')
    {
        try {
            // Generate unique filename
            $name = time() . '_' . uniqid() . '.' . $media->getClientOriginalExtension();

            // Store using Laravel's storage system
            $path = $media->storeAs($directory, $name, $disk);

            return $path;
        } catch (Exception $e) {
            Log::error('Media storage failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function storeMultiple(array $mediaArray, $model, string $directory, string $relationMethod = 'images', string $disk = 'public'): array
    {
        $createdRecords = [];

        foreach ($mediaArray as $media) {
            if ($media instanceof UploadedFile) {
                $path = self::store($media, $directory, $disk);

                if ($path) {
                    try {
                        $record = $model->$relationMethod()->create([
                            'image' => Storage::disk($disk)->url($path),
                            'original_name' => $media->getClientOriginalName(),
                            'file_path' => $path,
                            'size' => $media->getSize(),
                            'mime_type' => $media->getMimeType(),
                            'collection' => $relationMethod, // Add this line to set collection
                        ]);
                        $createdRecords[] = $record;
                    } catch (Exception $e) {
                        Log::error('Database record creation failed: ' . $e->getMessage());
                        // Clean up the uploaded file if database insert fails
                        self::delete($path, $disk);
                    }
                }
            }
        }

        return $createdRecords;
    }
    public static function update(UploadedFile $media, string $oldPath, string $directory, string $disk = 'public')
    {
        // Delete old file
        self::delete($oldPath, $disk);

        // Store new file
        return self::store($media, $directory, $disk);
    }
    public static function delete(string $path, string $disk = 'public'): bool
    {
        try {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->delete($path);
            }
            return true; // File doesn't exist, consider it deleted
        } catch (Exception $e) {
            Log::error('Media deletion failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function deleteAll($model, string $relationMethod = 'images', string $disk = 'public'): bool
    {
        try {
            foreach ($model->$relationMethod as $image) {
                // Extract path from URL or use file_path if available
                $path = $image->file_path ?? self::extractPathFromUrl($image->image);

                if ($path) {
                    self::delete($path, $disk);
                }

                $image->delete();
            }
            return true;
        } catch (Exception $e) {
            Log::error('Delete all media failed: ' . $e->getMessage());
            return false;
        }
    }
    public static function validateFileType(UploadedFile $file, array $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg']): bool
    {
        return in_array($file->getMimeType(), $allowedTypes) ||
            in_array(strtolower($file->getClientOriginalExtension()), array_map(function ($type) {
                return str_replace('image/', '', $type);
            }, $allowedTypes));
    }
    public static function validateFileSize(UploadedFile $file, int $maxSize = 5242880): bool
    {
        return $file->getSize() <= $maxSize;
    }
    public static function validateFiles(array $files, array $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'], int $maxSize = 5242880): array
    {
        $validFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                if (self::validateFileType($file, $allowedTypes) && self::validateFileSize($file, $maxSize)) {
                    $validFiles[] = $file;
                } else {
                    Log::warning('Invalid file: ' . $file->getClientOriginalName());
                }
            }
        }
        return $validFiles;
    }
    private static function extractPathFromUrl(string $url): ?string
    {
        // Remove the storage URL prefix to get the actual path
        $storagePath = str_replace(url('storage/'), '', $url);
        return $storagePath ?: null;
    }
    public static function getFileInfo(UploadedFile $file): array
    {
        return [
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
        ];
    }
}
