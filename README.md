# php7-framework

## Начало работы
* Создайте БД из дампа на mysql (для других бд изменить строку подключения в engine/db/DataBase по правилам PDO)
* Пропишите параметры подключения в (frontend||backend)/config/main.php
* Настройте на веб-сервере рабочую папку сайта на (frontend||backend)/web
* Откройте в браузере свой сайт
***
### Аккаунты сохраненные в users
* admin/admin роль admin
* user/user - роль * (любой авторизованный)

## Немного описания API
Немного подробнее в папке docs через doxygen

### Базовый контроллер
 - Layout - установка имени шаблона (views/layouts/main)
 - params - передача параметров между view и контроллером

 - selectAction() - выбор действия actionView
 - render(view, param) - формирование html кода представления
 - redirect(view) - перенаправление по произвольному url
 - accessRights() - возвращает список прав доступа, нужно переопределять в наследниках

### Представление
 - render(view, param) - выполнение кода в view (html+php)
 - endHead() - выводит строки подключения стилей - из Asset
 - endBody() - выводит строки подключения js - из Asset
 
### Базовый класс Model
 - getErrorsLoad() - возвращает последнюю ошибку
 - load(array) - загрузка данных в модель из массива
 - getFieldList() - возвращает список полей модели
 - getTableColumns() - возвращает список полей из талицы БД 

### ActiveRecord наследуется от Model
 - save() - созраняет данные текущей модели в талицу БД
 - delete(id) - удаляет строку из БД
 - findOne(id) - возвращает модель по id
 
### DataBase
 - executeQuery(query) - выполнить запрос
 - prepare(query) - создать подготовленный запрос
 - getErrors() - получить ошибки бд
