<?php

namespace backend\models\SearchModels;

/**
 * This is the model class for table "{{%access_roles}}".
 *
 * @property int $id
 * @property text $name

 */
 
class AccessRolesModel extends backend\models\AccessRolesModel
{
	public $Table = 'access_roles';
    /**
     * @inherited
     *
     */
	public $id;
	public $name;
	
	/**
     * @inherited
     *
     */
	public $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'name' => ['NAME', 'text', 'required']
	];
}

