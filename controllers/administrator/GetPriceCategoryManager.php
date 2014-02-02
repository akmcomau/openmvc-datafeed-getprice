<?php

namespace modules\datafeed_getPrice\controllers\administrator;

use core\controllers\administrator\CategoryManager;

class GetPriceCategoryManager extends CategoryManager {

	protected $show_admin_layout = TRUE;
	protected $controller_class = 'administrator/GetPriceCategoryManager';

	protected $permissions = [
		'index' => ['administrator'],
	];

	public function index($message = NULL) {
		$this->category_manager($message, '\modules\datafeed_getprice\classes\models\GetPriceCategory', FALSE);
	}
}