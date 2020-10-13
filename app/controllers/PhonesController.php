<?php
namespace controllers;

use core\Controller;

use lib\DB\DbPdo;

class PhonesController extends Controller
{
    /**
     * Телефонная книга
     */
    function indexAction ()
    {
        //   Work with model   //
        $phoneBook = $this->loadModel('PhoneBook');

        // Типа rest :) //
        if (isset($_GET['get'])) {
            echo json_encode($phoneBook->getPhones($this->user['id']), JSON_UNESCAPED_UNICODE);
        }
        else if (isset($_GET['delete'])) {
            $phoneBook->deletePhone($_GET['delete']);
            echo 'ok';
        }
        else if (isset($_GET['update'])) {
            $phone = json_decode($_GET['vals']);
            if (isset($phone->phone[0])) $phone->phone[0] = urlencode($phone->phone[0]);
            $phoneBook->updatePhone($phone);
            echo 'ok';
        }
        else if (isset($_GET['newEntry'])) {
            $phone = json_decode($_GET['vals']);
            if (isset($phone->phone[0])) $phone->phone[0] = urlencode($phone->phone[0]);
            $phoneBook->createPhone($phone, $this->user['id']);
            echo 'ok';
        }

        // Render index //
        else {
            $phones = $phoneBook->getPhones($this->user['id']);
            $this->view->render('Моя телефонная книга', ["phones" => $phones]);
        }
    }
}
