<?php
// Validators/ImageValidator.php
namespace Validators;

use Src\Validator\AbstractValidator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Field :field must be a valid image (JPEG, PNG, GIF)';

    public function rule(): bool
    {
        if (empty($this->value['tmp_name'])) {
            return true; // Не требуется, если файл не загружен
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $this->value['tmp_name']);
        finfo_close($fileInfo);

        return in_array($mimeType, $allowedTypes);
    }
}