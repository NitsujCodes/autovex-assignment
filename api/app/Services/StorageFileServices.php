<?php

namespace App\Services;

use App\Models\StorageFile;
use Exception;
use Generator;
use Illuminate\Support\Facades\Storage;

class StorageFileServices
{
    /**
     * Create StorageFile
     *
     * @param array $data
     * @return StorageFile
     */
    public static function createStorageFile(array $data) : StorageFile
    {
        return StorageFile::query()->create($data);
    }

    /**
     * Get StorageFile by id
     *
     * @param int $id
     * @return StorageFile
     */
    public static function getStorageFileById(int $id) : StorageFile
    {
        return StorageFile::query()->findOrFail($id);
    }

    /**
     * Get StorageFile by uuid
     *
     * @param string $uuid
     * @return StorageFile
     */
    public static function getStorageFileByUuid(string $uuid) : StorageFile
    {
        return StorageFile::query()->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Update StorageFile
     *
     * @param int|StorageFile $storageFile
     * @param array $data
     * @return StorageFile
     */
    public static function updateStorageFile(int|StorageFile $storageFile, array $data) : StorageFile
    {
        if (is_int($storageFile)) {
            $storageFile = self::getStorageFileById($storageFile);
        }
        $storageFile->update($data);

        return $storageFile;
    }

    /**
     * Download StorageFile
     *
     * @param int|StorageFile $storageFile
     * @return string
     */
    public static function downloadStorageFile(int|StorageFile $storageFile) : string
    {
        if (is_int($storageFile)) {
            $storageFile = self::getStorageFileById($storageFile);
        }

        return Storage::disk($storageFile->disk)->get($storageFile->path);
    }

    /**
     * Stream StorageFile
     *
     * @param int|StorageFile $storageFile
     * @param int $bufferSize
     * @return Generator
     * @throws Exception
     */
    public static function streamStorageFile(int|StorageFile $storageFile, int $bufferSize = 1024) : Generator
    {
        $stream = self::getStorageFileAsStream($storageFile);

        if (is_null($stream)) {
            throw new Exception('Could not open stream');
        }

        try {
            while (!feof($stream)) {
                if (($buffer = fread($stream, $bufferSize)) === false) {
                    break;
                }
                yield $buffer;
            }
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }
    }

    /**
     * Get StorageFile as stream
     *
     * @param int|StorageFile $storageFile
     * @return null|resource
     */
    public static function getStorageFileAsStream(int|StorageFile $storageFile)
    {
        if (is_int($storageFile)) {
            $storageFile = self::getStorageFileById($storageFile);
        }

        return Storage::disk($storageFile->disk)->readStream($storageFile->path);
    }

    /**
     * Write to StorageFile by stream
     *
     * @param int|StorageFile $storageFile
     * @param resource $stream
     * @param array $options
     * @return bool
     */
    public static function writeToStorageFileByStream(int|StorageFile $storageFile, mixed $stream, array $options) : bool
    {
        if (is_int($storageFile)) {
            $storageFile = self::getStorageFileById($storageFile);
        }

        return Storage::disk($storageFile)->writeStream($storageFile->path, $stream, $options);
    }

    /**
     * Remove StorageFile
     *
     * @param int|StorageFile $storageFile
     * @return void
     */
    public static function removeStorageFile(int|StorageFile $storageFile) : void
    {
        StorageFile::query()->findOrFail($storageFile)->delete();
    }

    /**
     * Create StorageFile from upload
     *
     * @param array $data
     * @return StorageFile
     */
    public static function createStorageFileFromUpload(array $data) : StorageFile
    {
        // TODO: Implement upload handling
        return StorageFile::query()->create($data);
    }
}
