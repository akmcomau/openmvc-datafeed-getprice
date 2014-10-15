<?php

namespace modules\datafeed_getprice\controllers;

use core\classes\Model;
use core\classes\renderable\Controller;

class GetPrice extends Controller {

	public function getAllUrls($include_filter = NULL, $exclude_filter = NULL) {
		return [];
	}

	public function index() {
		$module_config = $this->config->moduleConfig('\modules\datafeed_getprice');
		$model = new Model($this->config, $this->database);
		$products = $model->getModel('\modules\products\classes\models\Product')->getMulti([
			'site_id' => ['type'=>'in', 'value'=>$this->allowedSiteIDs()],
			'active' => TRUE
		]);

		$getprice = $model->getModel('\modules\products\classes\models\ProductAttribute')->get([
			'name' => 'GetPrice Category',
		]);

		$data = [[
			'Product Name', 'SKU', 'Product ID', 'Short Description', 'Category Name',
			'Brand', 'Model', 'Image Link', 'Product URL', 'Price', 'Shipping Costs',
			'Shipping Times'
		]];
		foreach ($products as $product) {
			$category = '';
			$attributes = $product->getAttributes();
			if (isset($attributes[$getprice->id])) {
				$category_db = $model->getModel('\modules\datafeed_myshopping\classes\models\MyShoppingCategory')->get([
					'id' => $attributes[$getprice->id]->product_attribute_category_id,
				]);
				$category = $category_db->name;
			}

			$images = $product->getImages();
			$image = '';
			if (isset($images[0])) {
				$image = $images[0]->getThumbnailUrl();
			}

			$description = $product->description;
			$description = str_replace("\n", ' ', $description);
			$description = str_replace("\r", '', $description);
			$description = substr(strip_tags($description), 0, 255);

			$data[] = [
				$product->name,
				$product->sku,
				$product->id,
				$description,
				$category,
				$product->getBrandName(),
				$product->model,
				$image,
				$product->getUrl($this->url),
				$product->sell,
				'',
				'',
			];
		}

		$csv = $this->response->arrayToCsv($data);
		if ($module_config->enclosure_escaping == 'backslash') {
			$csv = str_replace('""', '\\"', $csv);
		}
		$this->response->setCsvContent($this, $csv);
	}
}