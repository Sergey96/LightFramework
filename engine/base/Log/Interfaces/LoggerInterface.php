<?php
 
namespace engine\base\Log\Interfaces;
 
/**
 * Описывает систему протоколирования.
 *
 * Сообщение ДОЛЖНО быть строкой или объектом, реализующим __toString().
 *
 * Сообщение МОЖЕТ содержать плейсхолдеры в виде {foo}, где foo будет
 * заменено на значение элемента массива context с ключом "foo".
 *
 * Массив context может содержать произвольные данные. Единственное
 * предположение, допустимое для разработчиков, заключается в том, что
 * если в массиве переда объект исключения для построения трассировки
 * стека, он ДОЛЖЕН находиться в элементе массива с ключом "exception".
 *
 * См. полную спецификацию интерфейса здесь: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 */
interface LoggerInterface
{
    /**
     * Авария, система неработоспособна.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function emergency($message, array $context = array());
 
    /**
     * Тревога, меры должны быть предприняты незамедлительно.
     *
     * Примеры: весь веб-сайт недоступен, БД недоступна и т.д. Вплоть до
     * отправки SMS-сообщения ответственному лицу.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function alert($message, array $context = array());
 
    /**
     * Критическая ошибка, критическая ситуация.
     *
     * Пример: недоступен компонент приложения, неожиданное исключение.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function critical($message, array $context = array());
 
    /**
     * Ошибка на стадии выполнения, не требующая неотложного вмешательства,
     * но требующая протоколирования и дальнейшего изучения.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function error($message, array $context = array());
 
    /**
     * Предупреждение, нештатная ситуация, не являющаяся ошибкой.
     *
     * Пример: использование устаревшего API, неверное использование API,
     * нежелательные эффекты и ситуации, которые, тем не менее,
     * не обязательно являются ошибочными.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function warning($message, array $context = array());
 
    /**
     * Замечание, важное событие.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function notice($message, array $context = array());
 
    /**
     * Информация, полезные для понимания происходящего события.
     *
     * Пример: авторизация пользователя, протокол взаимодействия с БД.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function info($message, array $context = array());
 
    /**
     * Детальная отладочная информация.
     *
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function debug($message, array $context = array());
 
    /**
     * Протоколирование с произвольным уровнем.
     *
     * @param смешанный $level
     * @param строка $message
     * @param массив $context
     * @return null
     */
    public function log($level, $message, array $context = array());
}