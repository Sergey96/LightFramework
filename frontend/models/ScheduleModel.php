<?php

namespace frontend\models;

/**
 * This is the model class for table "{{%schedule}}".
 *
 * @property int $id
 * @property int $id_group
 * @property int $number_work
 * @property text $type_week
 * @property int $number_day
 * @property int $sub_group
 * @property text $type_work
 * @property text $title_work
 * @property text $room
 * @property int $id_teacher

 */
 
class ScheduleModel extends \engine\DB\ActiveRecord
{
	public $Table = 'schedule';
    /**
     * @inherited
     *
     */
	public $id;
	public $id_group;
	public $number_work;
	public $type_week;
	public $number_day;
	public $sub_group;
	public $type_work;
	public $title_work;
	public $room;
	public $id_teacher;
	
	/**
     * @inherited
     *
     */
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'id_group' => ['ID_GROUP', 'int', 'required'],
		'number_work' => ['NUMBER_WORK', 'int', 'required'],
		'type_week' => ['TYPE_WEEK', 'text', 'null'],
		'number_day' => ['NUMBER_DAY', 'int', 'required'],
		'sub_group' => ['SUB_GROUP', 'int', 'required'],
		'type_work' => ['TYPE_WORK', 'text', 'required'],
		'title_work' => ['TITLE_WORK', 'text', 'required'],
		'room' => ['ROOM', 'text', 'required'],
		'id_teacher' => ['ID_TEACHER', 'int', 'required']
	];
	
	public function getAll(){
		return $this->getData($this->getFieldList(self::$attributeLabels), 25);
	}
}

