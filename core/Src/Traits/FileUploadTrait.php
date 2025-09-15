<?php
// Traits/FileUploadTrait.php
namespace Src\Traits;

trait FileUploadTrait
{
    protected function uploadFile(array $file, string $directory): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = $directory . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return $filename;
        }

        return null;
    }

    protected function deleteFile(string $filepath): bool
    {
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        return false;
    }
}