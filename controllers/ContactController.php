<?php

namespace controllers;


use core\base\Controller;
use core\Router;
use models\Contact;
use models\ContactForm;


class ContactController extends Controller
{
    /**
     * @var object экземпляр модели
     */
    private $model;

    /**
     * Конструктор класса ContactController. Создает экземпляр ContactModel и сохраняет в
     * $this->model. Устанавливает путь до шаблона
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Contact();

        // устанавливаем шаблон
        $this->layout = 'layouts/main';
    }

    /**
     * Выводит список контактов
     *
     * @return void
     */
    public function actionIndex()
    {
        $contacts = $this->model->getAllContacts();

        return $this->render('contact/index', [
            'contacts' => $contacts
        ]);
    }

    /**
     * Удаляет контакт, id которого был передан в качестве параметра
     *
     * @param int
     * @return void
     */
    public function actionDelete($id = null)
    {
        if ($id !== null) {

            $this->model->deleteContact($id);

        }
        $this->redirect('contact/index');
    }

    /**
     * Выводит форму для изменения контакта, а так же сохраняет контакт в базу.
     * При открытии страницы просто возвращает форму со списком городов.
     * Если $form->send() вернул true, значит, была нажата кнопка submit, тогда метод
     * $form->load() получает данные формы, валидирует их и возвращает либо true, либо false.
     * Если получение и валидация данных прошли успешно, данные сохраняются в БД и происходит
     * редирект к списку контактов, иначе снова возвращается форма изменения контакта, в которую
     * передаются все введенные пользователем данные и массив ошибок, совершенных пользователем при вводе.
     *
     * @param int
     * @return void
     */
    public function actionEdit($id = null)
    {
        $form = new ContactForm();

        // форма не отправлялась
        if (!$form->send()) {

            if ($id !== null) {

                $contact = $this->model->getOneContact($id);

                $cities = $this->model->getCities();

                $streets = [];

                if (isset($contact['city_id'])) {
                    $streets = $this->model->getStreets($contact['city_id']);
                }

                $this->title = $contact['surname'] . ' ' . $contact['name'] .' изменение данных';

                return $this->render('contact/form', [
                    'contact' => $contact,
                    'cities' => $cities,
                    'streets' => $streets
                ]);
            }
        // форма отправлена
        } else {

            if ($form->load()) {

                $this->model->editContact($form->formData);

            } else {

                $cities = $this->model->getCities();

                $streets = [];

                if (isset($form->formData['city_id'])) {
                    $streets = $this->model->getStreets($form->formData['city_id']);
                }

                $this->title = 'Ошибка!';

                return $this->render('contact/form', [
                    'cities' => $cities,
                    'streets' => $streets,
                    'contact' => $form->formData,
                    'errors' => $form->errors
                ]);

            }
        }
        return $this->redirect('contact/index');
    }

    /**
     * Выводит форму для добавления контакта, а так же сохраняет контакт в базу.
     * При открытии страницы просто возвращает форму со списком городов.
     * Если $form->send() вернул true, значит, была нажата кнопка submit, тогда метод
     * $form->load() получает данные формы, валидирует их и возвращает либо true, либо false.
     * Если получение и валидация данных прошли успешно, данные сохраняются в БД и происходит
     * редирект к списку контактов, иначе снова возвращается форма изменения контакта, в которую
     * передаются все введенные пользователем данные и массив ошибок, совершенных пользователем при вводе.
     *
     * @return void
     */
    public function actionAdd()
    {
        $form = new ContactForm();

        // форма не отправлялась
        if (!$form->send()) {

            $cities = $this->model->getCities();

            $this->title = 'Добавить контакт';

            return $this->render('contact/form', [
                'cities' => $cities
            ]);
        // форма отправлена
        } else {

            if ($form->load()) {

                $this->model->addContact($form->formData);

            } else {

                $streets = [];

                if (isset($form->formData['city_id'])) {
                    $streets = $this->model->getStreets($form->formData['city_id']);
                }

                $cities = $this->model->getCities();

                $this->title = 'Ошибка!';

                return $this->render('contact/form', [
                    'cities' => $cities,
                    'streets' => $streets,
                    'contact' => $form->formData,
                    'errors' => $form->errors
                ]);
            }
        }
        return $this->redirect('contact/index');
    }

    /**
     * Получает id выбранного в выпадающем меню города и возвращает список улиц, находящихся
     * в нем. Работает через ajax
     *
     * @param int
     * @return void
     */
    public function actionGetStreets()
    {
        if ($this->isAjax()) {

            $id = (int)$_POST['id'];

            if (!isset($id)) {
                return false;
            }

            $streets = $this->model->getStreets($id);

            echo json_encode($streets);
        }
    }
}