<?php
namespace lib;


class PhotoArchive
{
    protected $path;


    public function __construct()
    {
        $this->path = dirname(__DIR__, 2)."/vars/photo/";
    }


    protected function getFileExt(string $path): string
    {
        return strtolower(pathinfo($path)['extension']);
    }


    /**
     * Проверка $_FILES на ошибки
     */
    public function checkErrors(): array
    {
        $errors = [];

        // Load error
        if ($_FILES['photo']['error'] > 0) {
            $errors[] = "Load error.";
        }

        // File size
        if ($_FILES['photo']['size'] > (5 * 1024 * 1024)) {
            $errors[] = "Max file size 5M.";
        }

        // File extension
        if ($_FILES['photo']['error'] == 0) {
            $fileExt = $this->getFileExt($_FILES['photo']['name']);
            $extensions = array("jpeg", "jpg", "png");
            if (in_array($fileExt, $extensions) === false) {
                $errors[] = "Extension not allowed: " . implode(", ", $extensions);
            }
        }

        return $errors;
    }


    /**
     * Сохранение фото
     */
    public function savePhoto(): string
    {
        // Hush file name
        $ext = $this->getFileExt($_FILES['photo']['name']);
        $hashName = md5(date("Ymd:His:").$_FILES['photo']['name']).'.'.$ext;

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
