<?php

namespace backend\models;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property text $title
 * @property datetime $created
 * @property text $description
 * @property text $content
 * @property text $owner

 */
 
class ArticleModel extends \engine\DB\ActiveRecord
{
	public $Table = 'articles';
    /**
     * @inherited
     *
     */
	public $id;
	public $title;
	public $created;
	public $description;
	public $content;
	public $owner;
	
	/**
     * @inherited
     *
     */
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'title' => ['TITLE', 'text', 'required'],
		'created' => ['CREATED', 'datetime', 'null'],
		'description' => ['DESCRIPTION', 'text', 'required'],
		'content' => ['CONTENT', 'text', 'required'],
		'owner' => ['OWNER', 'text', 'null']
	];
	
	public function getAll(){
		return $this->getData($this->getFieldList(self::$attributeLabels), 25);
	}
}

