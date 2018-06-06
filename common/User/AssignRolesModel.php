<?php

namespace common\User;

/**
 * This is the model class for table "{{%assign_roles}}".
 *
 * @property int $id_user
 * @property int $id_roles

 */
 
class AssignRolesModel extends \engine\DB\ActiveRecord
{
	public $Table = 'assign_roles';
    /**
     * @inherited
     *
     */
	public $id;
	public $id_user;
	public $id_roles;
	
	/**
     * @inherited
     *
     */
	public  static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'id_user' => ['ID_USER', 'int', 'required'],
		'id_roles' => ['ID_ROLES', 'int', 'required']
	];
	
	public function getAll(){
		return $this->getData($this->getFieldList(self::$attributeLabels), 25);
	}
}

