<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

class FileSplitService
{
    protected $inputFile;
    protected $chunkSizeBytes;
    protected $outputDir;
    protected $fileExtension;

    public function __construct($inputFile, $chunkSizeMB = 4)
    {
        $this->inputFile = $inputFile;
        $this->chunkSizeBytes = $chunkSizeMB * 1024 * 1024; // Convert MB to bytes
        $this->outputDir = public_path('temp'); // Directory to store chunks

        // Ensure the output directory exists
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0777, true);
        }

        $this->fileExtension = pathinfo($inputFile, PATHINFO_EXTENSION);
    }

    /**
     * Split the file and upload chunks to the specified directory.
     *
     * This method takes the input file and splits it into chunks of the specified size.
     * Each chunk is uploaded to the specified directory.
     *
     * @param string $outputDir The path to the directory where the chunks should be uploaded.
     * @return array An array of paths to the uploaded chunks.
     * @throws \Exception If there is an error reading or uploading the file.
     */
    public function splitAndUpload(string $outputDir = null)
    {
        /**
         * Set the output directory if it is not already set.
         */
        $this->outputDir ??= $outputDir;

        /**
         * Check if the input file exists.
         */
        if (!file_exists($this->inputFile)) {
            throw new Exception("Input file does not exist: $this->inputFile");
        }

        /**
         * Get the size of the input file.
         */
        $fileSize = filesize($this->inputFile);

        /**
         * If the file size is less than or equal to the chunk size, upload the entire file.
         * This can happen if the file is small or if the chunk size is large.
         */
        if ($fileSize <= $this->chunkSizeBytes) {
            $partFilePath = $this->outputDir . '/' . uniqid() . '.' . $this->fileExtension;
            copy($this->inputFile, $partFilePath);
            return [$partFilePath];
        }

        /**
         * Otherwise, split the file into chunks.
         */
        $fileHandle = fopen($this->inputFile, 'rb');
        if ($fileHandle === false) {
            throw new Exception("Failed to open the file for reading.");
        }

        /**
         * Initialize variables to keep track of the number of parts and the paths to the parts.
         */
        $partNumber = 0;
        $uploadedPaths = [];

        /**
         * Read the file in chunks and upload each chunk to the specified directory.
         */
        while (!feof($fileHandle)) {
            $chunkData = fread($fileHandle, $this->chunkSizeBytes);
            if ($chunkData === false) {
                throw new Exception("Failed to read the file.");
            }

            $partFilePath = $this->outputDir . '/' . uniqid() . '.' . $this->fileExtension;
            file_put_contents($partFilePath, $chunkData);

            $uploadedPaths[] = $partFilePath;
        }

        /**
         * Close the file handle.
         */
        fclose($fileHandle);

        /**
         * Return the paths to the uploaded chunks.
         */
        return $uploadedPaths;
    }

    /**
     * Clean up the uploaded chunks.
     */
    public function cleanup()
    {
        array_map('unlink', glob("{$this->outputDir}/*.{$this->fileExtension}"));
    }
}
