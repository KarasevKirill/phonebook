<?php


namespace models;


use core\base\Form;


class ContactForm extends Form
{
    /**
     * Валидирует поля формы добавления/изменения контакта
     * При возникновении ошибок сохраняет их в $this->errors
     *
     * @param array
     * @return boolean
     */
    protected function isValid()
    {
        if (empty(trim(strip_tags($this->formData['surname'])))) {
            $this->errors[] = 'Некорректная фамилия';
        }
        if (empty(trim(strip_tags($this->formData['name'])))) {
            $this->errors[] = 'Некорректное имя';
        }
        if (empty(trim(strip_tags($this->formData['patronymic'])))) {
            $this->errors[] = 'Некорректное отчество';
        }
        if (empty(trim(strip_tags($this->formData['city_id'])))) {
            $this->errors[] = 'Некорректный город';
        }
        if (empty(trim(strip_tags($this->formData['street_id'])))) {
            $this->errors[] = 'Некорректная улица';
        }
        if (empty(trim(strip_tags($this->formData['birthday'])))) {
            $this->errors[] = 'Некорректная дата рождения';
        }
        if (empty((int)trim(strip_tags($this->formData['phone'])))) {
            $this->errors[] = 'Некорректный номер телефона';
        }

        if (count($this->errors) > 0) {

            return false;
        }
        return true;
    }

    /**
     * Получает данные из формы и возвращает результат их валидации
     *
     * @return boolean
     */
    public function load()
    {
        $this->getFormData();

        return $this->isValid();
    }
}