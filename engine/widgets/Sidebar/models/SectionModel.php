<?php

namespace engine\widgets\Sidebar\models;

use engine\base\models\ActiveRecord;

/**
 * Модель - SectionModel Разделы сайдбара
 */
class SectionModel extends ActiveRecord
{
	public $Table = 'sidebar_section';

	/**
	 * id
	 */
	public $id;
	
	/**
	 * Заголовок раздела
	 */
	public $name;
	
	/**
	 * Правила валидации данных
	 */
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'name' => ['NAME', 'text', 'required'],
	];
	
	public function getAll(){
		return $this->getData($this->getFieldList(self::$attributeLabels), 25);
	}

}

