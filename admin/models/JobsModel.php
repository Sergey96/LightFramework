<?php

namespace admin\models;

/**
 * This is the model class for table "{{%jobs}}".
 *
 * @property bigint(20) unsigned $id
 * @property varchar(255) $queue
 * @property longtext $payload
 * @property tinyint(3) unsigned $attempts
 * @property int(10) unsigned $reserved_at
 * @property int(10) unsigned $available_at
 * @property int(10) unsigned $created_at

 */
 
class JobsModel extends \engine\base\models\ActiveRecord
{
	public $Table = 'jobs';
    /**
     * @inherited
     *
     */
	public $id;
	public $queue;
	public $payload;
	public $attempts;
	public $reserved_at;
	public $available_at;
	public $created_at;
	
	/**
     * @inherited
     *
     */
	public static $attributeLabels =
	[
		'id' => ['ID', 'bigint(20) unsigned', 'autoincrement'],
		'queue' => ['QUEUE', 'varchar(255)', 'required'],
		'payload' => ['PAYLOAD', 'longtext', 'required'],
		'attempts' => ['ATTEMPTS', 'tinyint(3) unsigned', 'required'],
		'reserved_at' => ['RESERVED_AT', 'int(10) unsigned'],
		'available_at' => ['AVAILABLE_AT', 'int(10) unsigned', 'required'],
		'created_at' => ['CREATED_AT', 'int(10) unsigned', 'required']
	];
}

