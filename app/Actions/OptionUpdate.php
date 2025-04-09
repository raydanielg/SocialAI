<?php

namespace App\Actions;

use App\Models\Option;
use App\Traits\Uploader;
use Illuminate\Support\Arr;

class OptionUpdate
{
  use Uploader;

  private array $optionData;
  private array $oldData = [];

  public function __construct()
  {
    // Get all data from request
    $this->optionData = [...request()->all()];
  }

  public function update($option_key)
  {
    // Get option from database or create new one
    $option = Option::query()->firstOrNew(
      [
        'key' => $option_key,
        'lang' => app()->getLocale()
      ],
      [
        'value' => []
      ]
    );

    if ($option->exists) {
      $this->oldData = $option->value ?? [];
    }

    // Upload files
    $this->uploadFiles();
    // Set value to option
    $option->value = $this->optionData;
    // Save option
    $option->save();
  }

  private function uploadFilesRecursive($data, $prefix = '')
  {
    $uploadedData = [];

    foreach ($data as $key => $value) {
      $fileKey = $prefix . $key;

      if (is_array($value)) {
        // Check if the array is associative or indexed
        $isAssociative = Arr::isAssoc($value);

        if ($isAssociative) {
          // Recursively upload files in the nested associative array
          $uploadedData[$key] = $this->uploadFilesRecursive($value, $fileKey . '.');
        } else {
          // Recursively upload files in the nested indexed array
          $uploadedData[$key] = [];
          foreach ($value as $index => $item) {
            $uploadedData[$key][$index] = $this->uploadFilesRecursive($item, $fileKey . '.' . $index . '.');
          }
        }
      } elseif ($value instanceof \Illuminate\Http\UploadedFile) {
        // Delete old file if it exists
        $oldFilePath = $this->getOldFilePath($fileKey);
        if ($oldFilePath !== null && is_file($oldFilePath)) {
          unlink($oldFilePath);
        }

        request()->validate([
          $fileKey => ['image'],
        ]);


        // Upload the file and set the value to the uploaded path
        $uploadedData[$key] = (string) $this->uploadFile($fileKey, '');
      } else {
        // Keep non-file values as they are
        $uploadedData[$key] = $value;
      }
    }

    return $uploadedData;
  }

  private function getOldFilePath($fileKey)
  {
    $filePath = data_get($this->oldData, $fileKey);

    if ($filePath !== null && file_exists(public_path($filePath))) {
      return public_path($filePath);
    }
    return null;
  }

  public function uploadFiles()
  {
    // Your request data
    $requestData = request()->all();

    // Call the recursive function for the entire request data
    $modifiedOptionData = $this->uploadFilesRecursive($requestData);
    $this->optionData = $modifiedOptionData;

    // Now $this->optionData contains the processed data
    // You can do further processing or return the result as needed
  }
}
