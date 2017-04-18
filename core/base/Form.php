<?php


namespace core\base;


abstract class Form
{
    /**
     * @var array хранит ошибки, возникшие при валидации формы
     */
    public $errors = [];

    /**
     * @var array хранит данные, полученные из формы
     */
    public $formData = [];

    /**
     * @var string хранит "имя формы" т.е. имя массива, в котором хранятся данные формы
     */
    protected $formName;

    /**
     * @var string имя кнопки на форме
     */
    protected $submitName;

    /**
     * Конструктор класса Form. Устанавливает "имя формы" т.е. имя массива, в котором хранятся
     * данные формы и имя submit кнопки, по которой можно будет определить отправку формы
     *
     * @return void
     */
    public function __construct()
    {
        $this->formName = $this->getFormName();
        $this->submitName = $this->getSubmitName();
    }

    /**
     * Извлекает данные формы из массива $_POST
     *
     * @return array
     */
    public function getFormData()
    {
        $this->formData = $_POST[$this->formName];
    }

    /**
     * Проверяет, была ли отправлена форма
     *
     * @return boolean
     */
    public function send()
    {
        return isset($_POST[$this->submitName]);
    }

    /**
     * Возвращает "имя формы" т.е. имя массива, в котором хранятся данные формы
     *
     * @return string
     */
    protected function getFormName()
    {
        $fullName = get_called_class();

        $array = explode('\\', $fullName);

        $name = end($array);

        return strtolower(str_replace('Form', '', $name));

    }

    /**
     * Возвращает имя submit кнопки формы. По умолчанию - 'submit'
     *
     * @return string
     */
    protected function getSubmitName()
    {
        return 'submit';
    }
    
    /**
     * Какая форма без валидации :)
     *
     * @param array
     */
    abstract protected function isValid();
}