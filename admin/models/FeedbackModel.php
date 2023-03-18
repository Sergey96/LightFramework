<?php

namespace admin\models;
 
use engine\base\models\ActiveRecord;

class FeedbackModel extends ActiveRecord
{
	public $Table = 'feedback';
	
	// Поля таблицы
	public $id;
	public $sender;
	public $sender_email;
	public $theme;
	public $content;
	public $created;
	public $readed;
	
	// Текстовые метки полей и правила валидации
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'sender' => ['Имя отправителя', 'text', 'required'],
		'sender_email' => ['Email отправителя', 'text', 'null'],
		'theme' => ['Тема', 'text', 'required'],
		'content' => ['Текст', 'text', 'required'],
		'created' => ['Создан', 'datetime', 'null'],
		'readed' => ['Прочитано', 'int', 'null']
	];
}

