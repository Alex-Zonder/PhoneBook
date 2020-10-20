<?php
namespace controllers;

use core\Controller;

use lib\Validator;
use lib\PhotoArchive;

class PhonesController extends Controller
{
    /**
     * Телефонная книга
     */
    function indexAction ()
    {
        //   Work with model   //
        $phoneBook = $this->loadModel('PhoneBook');

        //   Типа rest :)   //
        /**
         * Вывод записной книги
         */
        if (isset($_GET['get'])) {
            echo json_encode($phoneBook->getPhones($this->user['id']), JSON_UNESCAPED_UNICODE);
        }

        /**
         * Удаление записи
         */
        else if (isset($_GET['delete'])) {
            // Delete photo if exists
            $phone = $phoneBook->getPhone($_GET['delete'], $this->user['id']);
            if (isset($phone) && isset($phone['image'])) {
                $photoArchive = new PhotoArchive();
                $photoArchive->deletePhoto($phone['image']);
            }

            $phoneBook->deletePhone($_GET['delete'], $this->user['id']);

            echo 'ok';
        }

        /**
         * Обновление записи
         */
        else if (isset($_GET['update'])) {
            $phone = json_decode($_GET['vals']);
            if (isset($phone->phone[0])) $phone->phone[0] = urlencode($phone->phone[0]);

            //   Validation   //
            $errors = [];
            // Check email
            if (isset($phone->email) && !Validator::checkEmail($phone->email)) {
                    $errors[] = "Почта: не верный формат.";
            }
            // Check phone
            if (isset($phone->phone) && !Validator::checkPhone($phone->phone)) {
                $errors[] = "Телефон: не верный формат.";
            }

            // If errors
            if (count($errors) > 0) {
                echo json_encode($errors, JSON_UNESCAPED_UNICODE);
                return;
            }

            // Update entry
            $phoneBook->updatePhone($phone);

            echo 'ok';
        }

        /**
         * Добавление новой записи
         */
        else if (isset($_GET['newEntry'])) {
            // Get phone values //
            $phone = json_decode($_GET['vals']);
            if (isset($phone->phone[0])) $phone->phone[0] = urlencode($phone->phone[0]);

            //   Validation   //
            $errors = [];
            // Check name & lastName
            if ((!isset($phone->name) || $phone->name == '') && (!isset($phone->last_name) || $phone->last_name == '')) {
                $errors[] = 'Не заполнены поля имя и(или) фамилия';
            }
            // Check email
            if (isset($phone->email) && !Validator::checkEmail($phone->email)) {
                    $errors[] = "Почта: не верный формат.";
            }
            // Check phone
            if (isset($phone->phone) && !Validator::checkPhone($phone->phone)) {
                $errors[] = "Телефон: не верный формат.";
            }

            // If errors
            if (count($errors) > 0) {
                echo json_encode($errors, JSON_UNESCAPED_UNICODE);
                return;
            }

            // Create entry
            $phoneBook->createPhone($phone, $this->user['id']);

            echo 'ok';
        }

        /**
         * Вывод фото
         */
        else if (isset($_GET['photo'])) {
            // Check owner
            if (!$phoneBook->checkImageOwher($_GET['photo'], $this->user['id'])) {
                echo 'No photo: ', $_GET['photo'];
                return;
            }

            // Load photo
            $photoArchive = new PhotoArchive();
            $photoArchive->loadPhoto($_GET['photo']);
        }

        /**
         * Удаление фото
         */
         else if (isset($_GET['deletePhoto'])) {
             // Check owner
             if (!$phoneBook->checkImageOwher($_GET['deletePhoto'], $this->user['id'])) {
                 echo 'No photo: ', $_GET['deletePhoto'];
                 return;
             }

             // Delete photo
             $phoneBook->deleteImage($_GET['phoneId'], $this->user['id'], $_GET['deletePhoto']);
             $photoArchive = new PhotoArchive();
             $photoArchive->deletePhoto($_GET['deletePhoto']);

             echo "ok";
         }

        /**
         * Загрузка фото
         */
        else if (count($_FILES) > 0) {
            // Check errors
            $errors = [];

            // Phone id not set
            if (!isset($_POST['phoneId']) || $_POST['phoneId'] == '' || $_POST['phoneId'] == '-1') {
                $errors[] = "Phone id not set.";
            }

            // Check load errors
            $photoArchive = new PhotoArchive();
            $errors = array_merge($errors, $photoArchive->checkErrors());

            // If errors
            if (count($errors) > 0) {
                echo json_encode($errors, JSON_UNESCAPED_UNICODE);
                return;
            }

            // If photo alredy exists - remove
            $phone = $phoneBook->getPhone($_POST['phoneId'], $this->user['id']);
            if (isset($phone) && isset($phone['image'])) {
                $photoArchive->deletePhoto($phone['image']);
            }

            // Save photo
            $photoName = $photoArchive->savePhoto();
            $phoneBook->setImage($_POST['phoneId'], $this->user['id'], $photoName);

            echo 'ok:'.$photoName;
        }

        /**
         * Вывод страницы с книгой
         */
        else {
            $phones = $phoneBook->getPhones($this->user['id']);
            $this->view->render('Моя телефонная книга', ["phones" => $phones]);
        }
    }
}
