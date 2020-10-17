<?php
namespace lib;

class PhotoArchive
{
    public $path;

    public function __construct()
    {
        $this->path = dirname(__DIR__, 2)."/vars/photo/";
    }

    public function checkErrors(): array
    {
        $errors = [];

        // Load error
        if ($_FILES['photo']['error'] > 0) {
            $errors[] = "Load error";
        }

        // File size
        if ($_FILES['photo']['size'] > (5 * 1024 * 1024)) {
            $errors[] = "Max file size 5M";
        }

        // File ext
        $fileExp = strtolower(explode('.', $_FILES['photo']['name'])[count(explode('.', $_FILES['photo']['name']))-1]);
        $expansions = array("jpeg", "jpg", "png");
        if (in_array($fileExp, $expansions) === false) {
            $errors[] = "Extension not allowed: " . implode(", ", $expansions);
        }

        return $errors;
    }

    public function savePhoto()
    {
        move_uploaded_file($_FILES['photo']['tmp_name'], $this->path.$_FILES['photo']['name']);
        chmod($this->path.$_FILES['photo']['name'], 0777);
    }

    public function loadPhoto($fileName)
    {
        // Get file
        $filePath = $this->path.$fileName;
        $file = file_get_contents($filePath, FILE_USE_INCLUDE_PATH);

        // Return file
        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="' . $fileName);
        header('Content-Length: ' . strlen($file));
        echo $file;
        return;
    }
}
