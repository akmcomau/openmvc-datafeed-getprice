<?php

namespace modules\datafeed_getprice\controllers;

use core\classes\Model;
use core\classes\renderable\Controller;

class GetPrice extends Controller {
	public function index() {
		$model = new Model($this->config, $this->database);
		$products = $model->getModel('\modules\products\classes\models\Product')->getMulti();

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
			if ($attributes[$getprice->id]) {
				$category_db = $model->getModel('\modules\datafeed_myshopping\classes\models\MyShoppingCategory')->get([
					'id' => $attributes[$getprice->id]->product_attribute_category_id,
				]);
				$category = $category_db->name;
			}

			$images = $product->getImages();
			$image = '';
			if (isset($images[0])) {
				$image = $this->config->getSiteUrl().$images[0]->getThumbnailUrl();
			}

			$data[] = [
				$product->name,
				$product->sku,
				$product->id,
				substr(strip_tags($product->description), 0, 255),
				$category,
				$product->getBrandName(),
				$product->model,
				$image,
				$image = $this->config->getSiteUrl().$product->getUrl($this->url),
				$product->sell,
				'',
				'',
			];
		}

		$csv = $this->response->arrayToCsv($data);
		$this->response->setCsvContent($this, $csv);
	}
}