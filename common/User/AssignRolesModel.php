<?php

namespace common\User;

use engine\base\models\ActiveRecord;

/**
 * This is the model class for table "{{%assign_roles}}".
 *
 * @property int $id_user
 * @property int $id_role
 */
 
class AssignRolesModel extends ActiveRecord
{
	public $Table = 'assign_roles';
    /**
     * @inherited
     *
     */
	public $id;
	public $id_user;
	public $id_role;
	
	/**
     * @inherited
     *
     */
	public  static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'id_user' => ['ID_USER', 'int', 'required'],
		'id_role' => ['ID_ROLE', 'int', 'required']
	];
	
	public function getAll(){
		return $this->getData($this->getFieldList(self::$attributeLabels), 25);
	}
}

