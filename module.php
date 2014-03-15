<?php
$_MODULE = [
	"name" => "Data Feed - GetPrice",
	"description" => "Adds a GetPrice data feed",
	"namespace" => "\\modules\\datafeed_getprice",
	"config_controller" => "administrator\\GetPrice",
	"controllers" => [
		"GetPrice",
		"administrator\\GetPrice",
		"administrator\\GetPriceCategoryManager",
	],
	"default_config" => [
		"default_category" => "",
		"enclosure_escaping" => "normal",
	]
];
