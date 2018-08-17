<?php

namespace Hedonist\Services;

use Illuminate\Http\UploadedFile;

class FileNameGenerator
{
    private $file;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function generateFileName(): string
    {
        return time() . '_' . mt_rand() . '.' . $this->file->extension();
    }
}