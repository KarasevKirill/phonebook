<?php

namespace models;


use core\base\Model;


class Contact extends Model
{
    /**
     * Возвращает все контакты из БД
     *
     * @return array
     */
    public function getAllContacts()
    {
        $contacts = $this->pdo->query("SELECT contact.id AS 'id',
                                            contact.surname AS 'surname',
                                            contact.name AS 'name',
                                            contact.patronymic AS 'patronymic',
                                            city.name AS 'city',
                                            street.name AS 'street',        
                                            contact.birthday AS 'birthday',
                                            contact.phone AS 'phone'
                                        FROM contact 
                                            LEFT JOIN city ON contact.city_id = city.id
                                            LEFT JOIN street ON contact.street_id = street.id
                                        ORDER BY contact.id
                                      ");

        return $contacts->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает контакт, id которого был передан в качестве параметра
     *
     * @param  int
     * @return array
     */
    public function getOneContact($id)
    {
        $contact = $this->pdo->prepare("SELECT contact.id AS 'id',
                                            contact.surname AS 'surname',
                                            contact.name AS 'name',
                                            contact.patronymic AS 'patronymic',
                                            contact.city_id AS 'city_id',
                                            contact.street_id AS 'street_id',       
                                            contact.birthday AS 'birthday',
                                            contact.phone AS 'phone'
                                        FROM contact
                                        WHERE
                                            contact.id = :id
                                    ");
        $contact->execute([
            'id' => $id
        ]);

        return $contact->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Добавляет контакт в БД. Принимает массив с данными контакта
     *
     * @param array
     * @return void
     */
    public function addContact($contact)
    {
        $query = $this->pdo->prepare("INSERT INTO contact (id, surname, name, patronymic, city_id, street_id, birthday, phone)
                                        VALUES (null, :surname, :name, :patronymic, :city_id, :street_id, :birthday, :phone);
                                    ");

        $query->execute([
            'surname' => $contact['surname'],
            'name' => $contact['name'],
            'patronymic' => $contact['patronymic'],
            'city_id' => $contact['city_id'],
            'street_id' => $contact['street_id'],
            'birthday' => $contact['birthday'],
            'phone' => $contact['phone']
        ]);
    }

    /**
     * Удаляет контакт, id которого передан в качестве параметра
     *
     * @param int
     * @return void
     */
    public function deleteContact($id)
    {
        $query = $this->pdo->prepare("DELETE FROM contact WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
    }

    /**
     * Изменяет существующий контакт. Принимает массив с данными контакта
     *
     * @param array
     * @return void
     */
    public function editContact($contact)
    {
        $query = $this->pdo->prepare("UPDATE 
                                            contact 
                                      SET 
                                            contact.surname = :surname, 
                                            contact.name = :name, 
                                            contact.patronymic = :patronymic, 
                                            contact.city_id = :city_id, 
                                            contact.street_id = :street_id, 
                                            contact.birthday = :birthday, 
                                            contact.phone = :phone
                                      WHERE
                                            contact.id = :id
                                    ");

        $query->execute([
            'id' => (int)$contact['id'],
            'surname' => $contact['surname'],
            'name' => $contact['name'],
            'patronymic' => $contact['patronymic'],
            'city_id' => (int)$contact['city_id'],
            'street_id' => (int)$contact['street_id'],
            'birthday' => $contact['birthday'],
            'phone' => $contact['phone']
        ]);
    }

    /**
     * Возвращает список городов
     *
     * @return array
     */
    public function getCities()
    {
        $cities = $this->pdo->query('SELECT * FROM city');

        return $cities->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает список улиц, находящихся в городе, id которого передан
     * в качестве параметра
     *
     * @param int
     * @return array
     */
    public function getStreets($id)
    {
        $query = $this->pdo->prepare("SELECT id, name FROM street WHERE city_id = :id");

        $query->execute([
            ':id' => $id
        ]);

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}