<?php

namespace backend\models;

/** 
 * Модель таблицы "{{%films}}".
 *
 * @property int $id
 * @property text $title
 * @property date $add_date
 * @property int $rating
 * @property text $status
 * @property text $description
 * @property text $url
 * @property text $director
 * @property text $company

 */
class FilmsModel extends \engine\DB\ActiveRecord
{
	/**
     * @inherited
     *
     */
	public $Table = 'films';
    
	public $id;
	public $title;
	public $add_date;
	public $rating;
	public $status;
	public $description;
	public $url;
	public $director;
	public $company;
	
	/**
     * @inherited
     *
     */
	public $attributeLabels =
	[
		'id' => ['ID', 'int', 'required'],
		'title' => ['TITLE', 'text', 'required'],
		'add_date' => ['ADD_DATE', 'date', 'required'],
		'rating' => ['RATING', 'int'],
		'status' => ['STATUS', 'text'],
		'description' => ['DESCRIPTION', 'text', 'required'],
		'url' => ['URL', 'text'],
		'director' => ['DIRECTOR', 'text'],
		'company' => ['COMPANY', 'text']
	];
}

