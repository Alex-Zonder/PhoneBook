<?php
namespace lib;

class PhotoArchive
{
    public $path;

    public function __construct()
    {
        $this->path = dirname(__DIR__, 2)."/vars/photo/";
    }

    protected function getFileExp(string $path): string
    {
        return strtolower(explode('.', $path)[count(explode('.', $path))-1]);
    }


    /**
     * Проверка $_FILES на ошибки
     */
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

        // File expansion
        $fileExp = $this->getFileExp($_FILES['photo']['name']);
        $expansions = array("jpeg", "jpg", "png");
        if (in_array($fileExp, $expansions) === false) {
            $errors[] = "Extension not allowed: " . implode(", ", $expansions);
        }

        return $errors;
    }


    /**
     * Сохранение фото
     */
    public function savePhoto()
    {
        // Hush file
        $exp = $this->getFileExp($_FILES['photo']['name']);
        $hashName = md5(date("Ymd:His:").$_FILES['photo']['name']).'.'.$exp;

        move_uploaded_file($_FILES['photo']['tmp_name'], $this->path.$hashName);
        chmod($this->path.$hashName, 0777);

        return $hashName;
    }


    /**
     * Удаление фото
     */
    public function deletePhoto(string $path): bool
    {
        if (!is_file($this->path.$path)) {
             return false;
        }

        unlink($this->path.$path);
        return true;
    }


    /**
     * Вывод фото
     */
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
