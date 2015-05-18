<?php
/**
 * Geo Search 类
 * 2015年5月
 * author ocre
 */
namespace Common\ORG;
class GeoSearch extends GeoApiBase {
	const NEARBY_URI             = "/geosearch/v3/nearby";
	const LOCAL_URI              = "/geosearch/v3/local";
	const BOUND_URI              = "/geosearch/v3/bound";
	const DETAIL_URI             = "/geosearch/v3/detail";

	public function __construct($options = array()) {
		parent::__construct($options);
	}
	
	/**
	 * poi周边搜索
	 *
	 */
	public function nearby($geotable_id, $params) {
		$defaultParams = array(
			'geotable_id' => $geotable_id,
			'q' => '',
			'location' => '',
			'coord_type' => 3,
			'radius' => 1000,
			'tags' => '',
			'sortby' => 'distance:1|weight:-1',
			'filter' => '',
			'page_index' => 0,
			'page_size' => 10,
			'callback' => '',
		);
		$params = array_merge($defaultParams, $params);
		$ret = $this->_apiGet(self::NEARBY_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}
	/**
	 * poi本地检索
	 *
	 */
	public function local($geotable_id, $params) {
		$defaultParams = array(
			'geotable_id' => $geotable_id,
			'q' => '',
			'coord_type' => 3,
			'region' => '',
			'tags' => '',
			'sortby' => '',
			'filter' => '',
			'page_index' => 0,
			'page_size' => 10,
			'callback' => '',
		);
		$params = array_merge($defaultParams, $params);
		$ret = $this->_apiGet(self::LOCAL_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}
	/**
	 * poi矩形检索
	 *
	 */
	public function bound($geotable_id, $params) {
		$defaultParams = array(
			'geotable_id' => $geotable_id,
			'q' => '',
			'coord_type' => 3,
			'bounds' => '',
			'tags' => '',
			'sortby' => '',
			'filter' => '',
			'page_index' => 0,
			'page_size' => 10,
			'callback' => '',
		);
		$params = array_merge($defaultParams, $params);
		$ret = $this->_apiGet(self::BOUND_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	/**
	 * poi详情检索
	 * uid为poi点的id值
	 */
	public function detail($geotable_id, $uid) {
		$params = array(
			'geotable_id' => $geotable_id,
			'coord_type' => 3,
		);
		$ret = $this->_apiGet(self::DETAIL_URI . '/' . $uid, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}
}

// class GeoSearchTest {
// 	private $_geoObj;

// 	public function __construct() {
// 		$configs = array(
// 			'ak' => 'qZNfS118gV9xPnMz8MsKc2AT',
// 			'sk' => 'B8h5AUGUOBhgYM19txNO5xRF8dM2GYnj',
// 		);
// 		$this->_geoObj = new GeoSearch($configs);
// 		header("Content-Type: text/html; charset=utf-8");
// 	}

// 	public function test_nearby() {
// 		$query['location'] = '116.336906,39.917694';
// 		$query['radius'] = 2000;
// 		echo json_encode($this->_geoObj->nearby(104341, $query)) .PHP_EOL;
// 		var_dump($this->_geoObj->getError());
// 	}
// }

// $testObj = new GeoSearchTest();
// $testObj->test_nearby();