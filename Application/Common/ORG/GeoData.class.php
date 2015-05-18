<?php
/**
 * Geo Data 类
 * 2015年5月
 * author ocre
 */
namespace Common\ORG;
class GeoData extends GeoApiBase {
	const CREATE_GEOTABLE_URI = "/geodata/v3/geotable/create";
	const LIST_GEOTABLE_URI = "/geodata/v3/geotable/list";
	const DETAIL_GEOTABLE_URI = "/geodata/v3/geotable/detail";
	const UPDATE_GEOTABLE_URI = "/geodata/v3/geotable/update";
	const DELETE_GEOTABLE_URI = "/geodata/v3/geotable/delete";
	const CREATE_COLUMN_URI = "/geodata/v3/column/create";
	const LIST_COLUMN_URI = "/geodata/v3/column/list";
	const DETAIL_COLUMN_URI = "/geodata/v3/column/detail";
	const UPDATE_COLUMN_URI = "/geodata/v3/column/update";
	const DELETE_COLUMN_URI = "/geodata/v3/column/delete";
	const CREATE_POI_URI = "/geodata/v3/poi/create";
	const LIST_POI_URI = "/geodata/v3/poi/list";
	const DETAIL_POI_URI = "/geodata/v3/poi/detail";
	const UPDATE_POI_URI = "/geodata/v3/poi/update";
	const DELETE_POI_URI = "/geodata/v3/poi/delete";
	const UPLOAD_POI_URI = "/geodata/v3/poi/upload"; // 批量上传数据（post pois csv file）接口
	const LIST_UPLOAD_POI_PROGRESS_URI = "/geodata/v3/job/listimportdata"; // 批量上传进度查询接口（支持查询成功，失败poi）
	const LIST_JOB_URI = "/geodata/v3/job/list"; // 批量操作任务查询（list job）接口
	const DETAIL_JOB_URI = "/geodata/v3/job/detail"; // 根据id查询批量任务（detail job）接口

	public function __construct($options = array()) {
		parent::__construct($options);
	}

	public function createGeotable($name) {
		$params = array(
			'name' => $name,
			'geotype' => 1,
			'is_published' => 1,
		);
		$ret = $this->_apiPost(self::CREATE_GEOTABLE_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function listGeotable($name = '') {
		$params = array(
			'name' => $name,
		);
		$ret = $this->_apiGet(self::LIST_GEOTABLE_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function detailGeotable($id) {
		$params = array(
			'id' => $id,
		);
		$ret = $this->_apiGet(self::DETAIL_GEOTABLE_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function updateGeotable($id, $updatedInfo) {
		$params['id'] = $id;
		if (isset($updatedInfo['is_published'])) $params['is_published'] = $updatedInfo['is_published'];
		if (isset($updatedInfo['name'])) $params['name'] = $updatedInfo['name'];
		$ret = $this->_apiPost(self::UPDATE_GEOTABLE_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	/**
	 * 删除geotable
	 * 注：当geotable里面没有有效数据时，才能删除geotable
	 */
	public function deleteGeotable($id) {
		$params['id'] = $id;
		$ret = $this->_apiPost(self::DELETE_GEOTABLE_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function createColumn($geotable_id, $key, $name, $type, $is_sortfilter_field, $is_search_field, $is_index_field, $is_unique_field = 0, $max_length = null, $default_value = null) {
		$params = array(
			'geotable_id' => $geotable_id,
			'key' => $key,
			'name' => $name,
			'type' => $type,
			'is_sortfilter_field' => $is_sortfilter_field,
			'is_search_field' => $is_search_field,
			'is_index_field' => $is_index_field,
			'is_unique_field' => $is_unique_field,
		);
		if (isset($max_length)) $params['max_length'] = $max_length;
		if (isset($default_value)) $params['default_value'] = $default_value;
		$ret = $this->_apiPost(self::CREATE_COLUMN_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function listColumn($geotable_id, $name = '', $key = '') {
		$params = array(
			'geotable_id' => $geotable_id,
			'key' => $key,
			'name' => $name,
		);
		$ret = $this->_apiGet(self::LIST_COLUMN_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function detailColumn($geotable_id, $id) {
		$params = array(
			'geotable_id' => $geotable_id,
			'id' => $id,
		);
		$ret = $this->_apiGet(self::DETAIL_COLUMN_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function updateColumn($geotable_id, $id, $updatedInfo) {
		$params = array(
			'geotable_id' => $geotable_id,
			'id' => $id,
		);
		if (isset($updatedInfo['name'])) $params['name'] = $updatedInfo['name'];
		if (isset($updatedInfo['default_value'])) $params['default_value'] = $updatedInfo['default_value'];
		if (isset($updatedInfo['max_length'])) $params['max_length'] = $updatedInfo['max_length'];
		if (isset($updatedInfo['is_sortfilter_field'])) $params['is_sortfilter_field'] = $updatedInfo['is_sortfilter_field'];
		if (isset($updatedInfo['is_search_field'])) $params['is_search_field'] = $updatedInfo['is_search_field'];
		if (isset($updatedInfo['is_index_field'])) $params['is_index_field'] = $updatedInfo['is_index_field'];
		if (isset($updatedInfo['is_unique_field'])) $params['is_unique_field'] = $updatedInfo['is_unique_field'];
		$ret = $this->_apiPost(self::UPDATE_COLUMN_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function deleteColumn($geotable_id, $id) {
		$params = array(
			'geotable_id' => $geotable_id,
			'id' => $id,
		);
		$ret = $this->_apiPost(self::DELETE_COLUMN_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function createPoi($geotable_id, $latitude, $longitude, $coord_type, $title = null, $address = null, $tags = null, $columns = array()) {
		$params = array(
			'geotable_id' => $geotable_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'coord_type' => $coord_type,
		);
		if (isset($title)) $params['title'] = $title;
		if (isset($address)) $params['address'] = $address;
		if (isset($tags)) $params['tags'] = $tags;
		if (isset($columns)) {
			foreach ($columns as $key => $value) {
				$params[$key] = $value;
			}
		}
		$ret = $this->_apiPost(self::CREATE_POI_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function listPoi($geotable_id, $page_index = 0, $page_size = 10, $tags = null, $title = null, $bounds = null, $columns = array()) {
		$params = array(
			'geotable_id' => $geotable_id,
			'page_index' => $page_index,
			'page_size' => $page_size,
		);
		if (isset($tags)) $params['tags'] = $tags;
		if (isset($title)) $params['title'] = $title;
		if (isset($bounds)) $params['bounds'] = $bounds;
		if (isset($columns)) {
			foreach ($columns as $key => $value) {
				$params[$key] = $value;
			}
		}
		$ret = $this->_apiGet(self::LIST_POI_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function detailPoi($geotable_id, $id) {
		$params = array(
			'geotable_id' => $geotable_id,
			'id' => $id,
		);
		$ret = $this->_apiGet(self::DETAIL_POI_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function updatePoi($geotable_id, $id, $unique_key_val, $latitude, $longitude, $coord_type, $title = null, $address = null, $tags = null, $columns = array()) {
		$unique_key = '';
		$unique_val = '';
		if (isset($unique_key_val)) {
			$tmpArr = explode(':', $unique_key_val, 2);
			if (count($tmpArr) == 2) {
				$unique_key = $tmpArr[0];
				$unique_val = $tmpArr[1];
			}
		}
		if (!isset($id) && ($unique_key === '' || $unique_val === '')) {
			$this->_error = '参数错误：id和unique_key_val至少需要存在一个';
			return false;
		}
		$params = array(
			'geotable_id' => $geotable_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'coord_type' => $coord_type,
		);
		if (isset($id)) $params['id'] = $id;
		if ($unique_val !== '') {
			$params[$unique_key] = $unique_val;
		}
		if (isset($title)) $params['title'] = $title;
		if (isset($address)) $params['address'] = $address;
		if (isset($tags)) $params['tags'] = $tags;
		if (isset($columns)) {
			foreach ($columns as $key => $value) {
				$params[$key] = $value;
			}
		}
		$ret = $this->_apiPost(self::UPDATE_POI_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function deletePoi($geotable_id, $id, $unique_key_val) {
		$unique_key = '';
		$unique_val = '';
		if (isset($unique_key_val)) {
			$tmpArr = explode(':', $unique_key_val, 2);
			if (count($tmpArr) == 2) {
				$unique_key = $tmpArr[0];
				$unique_val = $tmpArr[1];
			}
		}
		if (!isset($id) && ($unique_key === '' || $unique_val === '')) {
			$this->_error = '参数错误：id和unique_key_val至少需要存在一个';
			return false;
		}
		$params = array(
			'geotable_id' => $geotable_id,
		);
		if (isset($id)) $params['id'] = $id;
		if ($unique_val !== '') {
			$params[$unique_key] = $unique_val;
		}
		$ret = $this->_apiPost(self::DELETE_POI_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function bulkDeletePoi($geotable_id, $ids = null, $title = null, $tags = null, $bounds = null, $columns = array()) {
		$params = array(
			'geotable_id' => $geotable_id,
			'is_total_del' => 1,
		);
		if (isset($ids)) $params['ids'] = $ids;
		if (isset($title)) $params['title'] = $title;
		if (isset($tags)) $params['tags'] = $tags;
		if (isset($bounds)) $params['bounds'] = $bounds;
		if (isset($columns)) {
			foreach ($columns as $key => $value) {
				$params[$key] = $value;
			}
		}
		$ret = $this->_apiPost(self::DELETE_POI_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function uploadPoi($geotable_id, $poi_list_file) {
		$params = array(
			'geotable_id' => $geotable_id,
		);
		$files = array(
			'poi_list' => "@$poi_list_file"
		);
		$ret = $this->_apiPostFile(self::UPLOAD_POI_URI, $params, $files);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function listUploadPoiProgress($geotable_id, $job_id, $status = 0, $page_index = 0, $page_size = 10) {
		$params = array(
			'geotable_id' => $geotable_id,
			'job_id' => $job_id,
		);
		if (isset($status)) $params['status'] = $status;
		if (isset($page_index)) $params['page_index'] = $page_index;
		if (isset($page_size)) $params['page_size'] = $page_size;
		$ret = $this->_apiGet(self::LIST_UPLOAD_POI_PROGRESS_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function listJob($type = null, $status = null) {
		$params = array();
		if (isset($type)) $params['type'] = $type;
		if (isset($status)) $params['status'] = $status;
		$ret = $this->_apiGet(self::LIST_JOB_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	public function detailJob($id) {
		$params['id'] = $id;
		$ret = $this->_apiGet(self::DETAIL_JOB_URI, $params);
		if ($ret) {
			return $this->getResult();
		}else {
			return false;
		}
	}

	// private function _apiPost($uri, $params) {
	// 	$params['ak'] = $this->_ak;
	// 	ksort($params);
	// 	$sn = $this->_caculateSn($uri, $params);
	// 	$target = self::MAP_API_HTTP . $uri;
	// 	$params['poi_list'] = "@D:\\Data\\hospital_20150505.csv";
	// 	$params['sn'] = $sn;
	// 	return $this->_http($target, $params, 'POST');
	// }

	// private function _apiPostFile($uri, $params, $files) {
	// 	$params['ak'] = $this->_ak;
	// 	ksort($params);
	// 	$sn = $this->_caculateSn($uri, $params);
	// 	$target = self::MAP_API_HTTP . $uri;
	// 	$params = array_merge($params, $files);
	// 	$params['sn'] = $sn;
	// 	return $this->_http($target, $params, 'POST');
	// }
}

// class GeoDataTest {
// 	private $_geoData;

// 	public function __construct() {
// 		$configs = array(
// 			'ak' => 'qZNfS118gV9xPnMz8MsKc2AT',
// 			'sk' => 'B8h5AUGUOBhgYM19txNO5xRF8dM2GYnj',
// 		);
// 		$this->_geoData = new GeoData($configs);
// 		header("Content-Type: text/html; charset=utf-8");
// 	}

// 	public function test_create_geotable() {
// 		echo json_encode($this->_geoData->createGeotable('test_2')) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_list_geotable() {
// 		echo json_encode($this->_geoData->listGeotable()) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_detail_geotable() {
// 		echo json_encode($this->_geoData->detailGeotable(102859)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_update_geotable() {
// 		echo json_encode($this->_geoData->updateGeotable(102859, array('name'=>'test_table_name_updated'))) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_delete_geotable() {
// 		echo json_encode($this->_geoData->deleteGeotable(102898)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_create_column() {
// 		echo json_encode($this->_geoData->createColumn(102859, 'hospital_id', '医院ID', 1, 0, 0, 1, 1)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 		echo json_encode($this->_geoData->createColumn(102859, 'hospital_name', '医院名称', 3, 0, 1, 1, 0, 64)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 		//echo json_encode($this->_geoData->createColumn(102859, 'hospital_name2', '医院名称2', 3, 0, 1, 1, 0, 64)) .PHP_EOL;
// 		//var_dump($this->_geoData->getError());
// 		echo json_encode($this->_geoData->createColumn(102859, 'base_insurance', '基本医保', 1, 1, 0, 1, 0, null, 1)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_list_column() {
// 		echo json_encode($this->_geoData->listColumn(102859)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_detail_column() {
// 		echo json_encode($this->_geoData->detailColumn(102859, 132273)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_update_column() {
// 		$updatedInfo  = array(
// 			'is_unique_field' => 1, 
// 		);
// 		echo json_encode($this->_geoData->updateColumn(102859, 132273, $updatedInfo)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_delete_column() {
// 		echo json_encode($this->_geoData->deleteColumn(102859, 132283)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_create_poi() {
// 		$poiColumn = array('hospital_id' => '1', 'hospital_name' => '北京市西城区展览路社区卫生服务中心', 'base_insurance' => 1);
// 		echo json_encode($this->_geoData->createPoi(102859, '39.929638', '116.353072', 3, '西城区展览路卫生服务中心', '北京市西城区阜外北大街201号', '医院 社区医院 社区卫生服务中心', $poiColumn)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_list_poi() {
// 		echo json_encode($this->_geoData->listPoi(102859)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_detail_poi() {
// 		echo json_encode($this->_geoData->detailPoi(102859, 826280680)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_update_poi() {
// 		$updatedInfo  = array(
// 			'base_insurance' => 0,
// 			'hospital_name' => 'beijing xicheng zhanlanlu hospital',
// 		);
// 		echo json_encode($this->_geoData->updatePoi(102859, 826280680, null, '39.929638', '116.353072', 3, '西城区展览路卫生服务中心', '北京市西城区阜外北大街201号', '医院 社区医院 卫生服务中心', $updatedInfo)) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_delete_poi() {
// 		echo json_encode($this->_geoData->deletePoi(102859, 826280680, null)) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_bulk_delete_poi() {
// 		echo json_encode($this->_geoData->bulkDeletePoi(102859, '826280681,826280682,826280683')) . PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_upload_poi() {
// 		echo json_encode($this->_geoData->uploadPoi(102859, 'D:\\Data\\hospital_20150505.csv')) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_list_upload_progress() {
// 		echo json_encode($this->_geoData->listUploadPoiProgress(102859, '55488b24a39b65fa603c9873')) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_list_job() {
// 		echo json_encode($this->_geoData->listJob()) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// 	public function test_detail_job() {
// 		echo json_encode($this->_geoData->detailJob('554889fae22d1eb56c3c9872')) .PHP_EOL;
// 		var_dump($this->_geoData->getError());
// 	}

// }

//$testObj = new GeoDataTest();
//$testObj->test_create_geotable();
//$testObj->test_list_geotable();
//$testObj->test_detail_geotable();
//$testObj->test_update_geotable();
//$testObj->test_delete_geotable();
//$testObj->test_create_column();
//$testObj->test_list_column();
//$testObj->test_detail_column();
//$testObj->test_update_column();
//$testObj->test_delete_column();
//$testObj->test_create_poi();
//$testObj->test_list_poi();
//$testObj->test_detail_poi();
//$testObj->test_update_poi();
//$testObj->test_delete_poi();
//$testObj->test_bulk_delete_poi();
//$testObj->test_upload_poi();
//$testObj->test_list_upload_progress();
//$testObj->test_list_job();
//$testObj->test_detail_job();