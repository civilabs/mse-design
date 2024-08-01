<?php

namespace App\Service;

class FileUploadService
{

    public static function upload_document($file)
    {
        $extention = $file->getClientOriginalExtension();
        $file_name = uniqid('document_') . time() . '.' . $extention;
        $file->storeAs('public/project/document/file', $file_name);
        return $file_name;
    }
}
