<?php
/**
 * Geo Coding 类
 * 2015年5月
 * author ocre
 */
namespace Common\ORG;
class GeoCoding extends GeoApiBase {
	const GEOCODER_URI             = "/geocoder/v2/";

	public function __construct($options = array()) {
		parent::__construct($options);
		$this->_ak = isset($options['ak'])        ? $options['ak']        : '';
		$this->_sk = isset($options['sk'])        ? $options['sk']        : '';
	}

	public function getCoord($address, $city = null) {
		$params = array(
			'address' => $address,
			'output' => 'json',
		);
		if (isset($city)) $params['city'] = $city;
		$ret = $this->_apiGet(self::GEOCODER_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}
}

// class GeocodingTest {
// 	private $_geoObj;

// 	public function __construct() {
// 		$configs = array(
// 			'ak' => 'qZNfS118gV9xPnMz8MsKc2AT',
// 			'sk' => 'B8h5AUGUOBhgYM19txNO5xRF8dM2GYnj',
// 		);
// 		$this->_geoObj = new Geocoding($configs);
// 		header("Content-Type: text/html; charset=utf-8");
// 	}

// 	public function test_get_coord() {
// 		echo json_encode($this->_geoObj->getCoord('北京市西城区阜外北大街201号', '北京市')) .PHP_EOL;
// 		var_dump($this->_geoObj->getError());
// 	}
// }
// $testObj = new GeocodingTest();
// $testObj->test_get_coord();