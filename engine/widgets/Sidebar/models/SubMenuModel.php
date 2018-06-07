<?php

namespace engine\widgets\Sidebar\models;

/**
 * Модель - SectionModel Разделы сайдбара
 */
class SubMenuModel extends \engine\DB\ActiveRecord
{
	public $Table = 'sidebar_submenu';

	/**
	 * id
	 */
	public $id;
	
	/**
	 * Заголовок подменю
	 */
	public $name;
	
	/**
	 * Ссылка подменю
	 */
	public $link;
	
	/**
	 * ID раздела
	 */
	public $id_section;
	
	/**
	 * Правила валидации данных
	 */
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'name' => ['NAME', 'text', 'required'],
		'link' => ['LINK', 'text', 'required'],
		'id_section' => ['ID_SECTION', 'int', 'required']
	];
	
	public function getAll(){
		return $this->getData($this->getFieldList(self::$attributeLabels), 25);
	}

}