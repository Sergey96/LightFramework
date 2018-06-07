<?php

namespace backend\models;

/**
 * This is the model class for table "{{%tt}}".
 *
 * @property int $id
 * @property int $dd
 * @property int $ss
 * @property int $aa

 */
 
class TTModel extends \engine\DB\ActiveRecord
{
	public $Table = 'tt';
    /**
     * @inherited
     *
     */
	public $id;
	public $dd;
	public $ss;
	public $aa;
	
	/**
     * @inherited
     *
     */
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'dd' => ['DD', 'int', 'required'],
		'ss' => ['SS', 'int', 'required'],
		'aa' => ['AA', 'int', 'required']
	];
}

