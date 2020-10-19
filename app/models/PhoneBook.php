<?php
namespace models;

use core\Model;

class PhoneBook extends Model
{
    /**
     * Вывод записной книги
     */
    public function getPhones(int $ownerId): array
    {
        $query = 'SELECT * FROM phone_book WHERE owner_id = :owner_id';
        $params = ['owner_id' => $ownerId];
        $result = $this->db->getArray($query, $params);

        return $result;
    }

    /**
     * Подсчет записей
     */
    public function countPhones(int $ownerId): int
    {
        $query = 'SELECT count(*) FROM phone_book WHERE owner_id = :owner_id';
        $params = ['owner_id' => $ownerId];
        $result = $this->db->getArray($query, $params);

        return intval($result[0]["count(*)"]);
    }

    /**
     * Достать карточку
     */
    public function getPhone(int $id, int $ownerId): ?array
    {
        $query = 'SELECT * FROM phone_book WHERE id = :id AND owner_id = :owner_id';
        $params = [
            'id' => $id,
            'owner_id' => $ownerId
        ];
        $result = $this->db->getArray($query, $params);

        if (!isset($result[0])) {
            return null;
        }

        return $result[0];
    }

    /**
     * Удаление карточки
     */
    public function deletePhone(int $id, int $ownerId)
    {
        $query = 'DELETE FROM phone_book WHERE id = :id AND owner_id = :owner_id';
        $params = [
            'id' => $id,
            'owner_id' => $ownerId
        ];
        $this->db->query($query, $params);
    }

    /**
     * Обновление карточки
     */
    public function updatePhone(object $phone)
    {
        $query = "UPDATE phone_book SET name = :name, last_name = :last_name, email = :email, phone = :phone WHERE id = :id";
        $params = [
            'name' => $phone->name,
            'last_name' => $phone->last_name,
            'email' => $phone->email,
            'phone' => $phone->phone,
            'id' => $phone->id
        ];
        $this->db->query($query, $params);
    }

    /**
     * Создание новой карточки
     */
    public function createPhone(object $phone, int $owner_id)
    {
        $query = 'INSERT INTO phone_book (owner_id, name, last_name, email, phone) VALUES (:owner_id, :name, :last_name, :email, :phone)';
        $params = [
            'owner_id' => $owner_id,
            'name' => isset($phone->name) ? $phone->name : null,
            'last_name' => isset($phone->last_name) ? $phone->last_name : null,
            'email' => isset($phone->email) ? $phone->email : null,
            'phone' => isset($phone->phone) ? $phone->phone : null,
        ];
        $this->db->query($query, $params);
    }

    /**
     * Обновление фото
     */
    public function setImage(int $phoneId, int $ownerId, string $image)
    {
        $query = "UPDATE phone_book SET image = :image WHERE id = :id AND owner_id = :owner_id";
        $params = [
            'id' => $phoneId,
            'owner_id' => $ownerId,
            'image' => $image,
        ];
        $this->db->query($query, $params);
    }

    /**
     * Удаление фото
     */
    public function deleteImage(int $phoneId, int $ownerId)
    {
        $query = "UPDATE phone_book SET image = NULL WHERE id = :id AND owner_id = :owner_id";
        $params = [
            'id' => $phoneId,
            'owner_id' => $ownerId
        ];
        $this->db->query($query, $params);
    }

    /**
     * Проверка владельца фото
     */
    public function checkImageOwher(string $image, int $ownerId): bool
    {
        $query = "SELECT * FROM phone_book WHERE owner_id = :owner_id AND image = :image";
        $params = [
            'owner_id' => $ownerId,
            'image' => $image,
        ];
        $result = $this->db->getArray($query, $params);

        if (!isset($result[0])) {
            return false;
        }

        return true;
    }
}
