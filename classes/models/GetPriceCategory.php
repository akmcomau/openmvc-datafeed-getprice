<?php

namespace modules\datafeed_getprice\classes\models;

use core\classes\Model;
use core\classes\models\Category;

class GetPriceCategory extends Category {
	protected $table       = 'getprice_category';
	protected $primary_key = 'getprice_category_id';
	protected $columns     = [
		'getprice_category_id' => [
			'data_type'      => 'int',
			'auto_increment' => TRUE,
			'null_allowed'   => FALSE,
		],
		'site_id' => [
			'data_type'      => 'int',
			'null_allowed'   => FALSE,
		],
		'getprice_category_name' => [
			'data_type'      => 'text',
			'data_length'    => '128',
			'null_allowed'   => FALSE,
		],
		'getprice_category_parent_id' => [
			'data_type'      => 'int',
			'null_allowed'   => TRUE,
		],
	];

	protected $indexes = [
		'site_id',
		'getprice_category_parent_id',
	];

	protected $foreign_keys = [
		'getprice_category_parent_id' => ['getprice_category', 'getprice_category_id'],
	];
}
