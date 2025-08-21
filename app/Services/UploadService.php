<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class UploadService
{
    public function upload(UploadedFile $file, string $filename, string $folder = ''): bool|string
    {
        $imageKit = app('ImageKit\ImageKit');

        $response = $imageKit->upload([
            'file' => base64_encode(file_get_contents($file->getRealPath())),
            'fileName' => "{$filename}.{$file->getClientOriginalExtension()}",
            'folder' => "/sklibon-ims/{$folder}",
            'useUniqueFileName' => false,
            'isPrivateFile' => false
        ]);

        if (! $response->result) return false;

        return $response->result->url;
    }
}
