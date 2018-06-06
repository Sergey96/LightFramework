<?php

namespace common\User;

/**
 * This is the model class for table "{{%access_roles}}".
 *
 * @property int $id
 * @property text $name

 */
 
class AccessRolesModel extends \engine\DB\ActiveRecord
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
	
	public function getAll(){
		return $this->getData($this->getFieldList($this->attributeLabels), 25);
	}
}

