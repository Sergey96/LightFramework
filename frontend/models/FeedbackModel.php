<?php

namespace frontend\models;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property int $id
 * @property text $sender
 * @property text $sender_email
 * @property text $theme
 * @property text $content
 * @property datetime $created
 * @property int $readed

 */
 
class FeedbackModel extends \engine\DB\ActiveRecord
{
	public $Table = 'feedback';
    /**
     * @inherited
     *
     */
	public $id;
	public $sender;
	public $sender_email;
	public $theme;
	public $content;
	public $created;
	public $readed;
	
	/**
     * @inherited
     *
     */
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

