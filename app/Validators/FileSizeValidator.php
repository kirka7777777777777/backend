<?php
// Validators/FileSizeValidator.php
namespace Validators;

use Src\Validator\AbstractValidator;

class FileSizeValidator extends AbstractValidator
{
    protected string $message = 'Field :field must be less than :max_size MB';

    public function rule(): bool
    {
        if (empty($this->value['tmp_name'])) {
            return true;
        }

        $maxSize = $this->args[0] ?? 2; // По умолчанию 2MB
        $fileSize = $this->value['size'] / (1024 * 1024); // Convert to MB

        return $fileSize <= $maxSize;
    }
}