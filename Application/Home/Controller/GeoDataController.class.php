<?php
namespace Home\Controller;
use Think\Controller;
use Common\ORG\GeoData;
class GeoDataController extends Controller {
	private $_geoObj;

	public function _initialize() {
		$options = array(
			'ak' => C('LBSYUN_AK'),
			'sk' => C('LBSYUN_SK'),
		);
        $this->_geoObj = new GeoData($options);
        header("Content-Type: text/html; charset=utf-8");
    }

    private function _getTableId($tableName) {
        $data = $this->_geoObj->listGeotable();
        foreach ($data['geotables'] as $key => $value) {
            if ($tableName == $value['name']) {
                return $value['id'];
            }
        }
        return 0;
    }

    private function _prepareHospitalTable() {
    	$tableName = C('LBSYUN_HOSPITAL_TABLE_NAME');
    	$columns = array();
    	$columns[] = array(
    		'key' => 'hospital_id',
			'name' => 'hospital_id',
			'type' => 1,
			'is_sortfilter_field' => 0,
			'is_search_field' => 0,
			'is_index_field' => 1,
			'is_unique_field' => 1,
    	);
    	$columns[] = array(
    		'key' => 'hospital_name',
			'name' => 'hospital_name',
			'type' => 3,
			'is_sortfilter_field' => 0,
			'is_search_field' => 1,
			'is_index_field' => 1,
			'is_unique_field' => 0,
			'max_length' => 64,
    	);
    	$tableId = $this->_getTableId($tableName);
        if (!empty($tableId) && $tableId > 0) {
            $this->_deleteDataByTags($tableId, '医院');
        } else {
            $this->_createTable($tableName, $columns);
        }
        return $tableId;
    }

    private function _deleteDataByTags($tableId, $tags) {
        $ret = $this->_geoObj->bulkDeletePoi($tableId, null, null, $tags);
        //var_dump($ret);var_dump($this->_geoObj->getError());die();
    }

    private function _createTable($tableName, $columns) {
        $data = $this->_geoObj->createGeotable($tableName);
    	$tableId = $data['id'];
    	foreach ($columns as $key => $column) {
    		$ret = $this->_geoObj->createColumn($tableId, $column['key'], $column['name'], $column['type'], $column['is_sortfilter_field'], $column['is_search_field'], $column['is_index_field'], $column['is_unique_field'], $column['max_length']);
            var_dump($ret);
            var_dump($this->_geoObj->getError());
    	}
    }
    /**
     * 把数据库里的数据索引到百度LBS云存储。
     *
     */
	public function indexHospitals() {
    	set_time_limit(1800);
        $this->_prepareHospitalTable();
        $tableId = $this->_getTableId(C('LBSYUN_HOSPITAL_TABLE_NAME'));
    	if (ob_get_level() == 0) ob_start();
    	$count = 0;
    	$model = M('Hospital');
    	$data = $model->select();
    	foreach ($data as $key => $hospital) {
    		$address = $hospital['address'];
    		$city = $hospital['city'];
    		$lat = $hospital['latitude'];
    		$lng = $hospital['longitude'];
    		$poiColumn = array(
    			'hospital_id' => $hospital['id'], 
    			'hospital_name' => $hospital['name']
    		);
		    $result = $this->_geoObj->createPoi($tableId, $hospital['latitude'], $hospital['longitude'], 3, $hospital['name'], $hospital['address'], '医院 社区医院', $poiColumn);
		    if ($result) {
    			$count++;
    			if ($count % 10 == 0) {
    				echo $count . ' records indexed.' . PHP_EOL;
    				ob_flush();
    				flush();
    			}
    		}
    	}
    	echo 'all done! ' . $count . ' records indexed.' . PHP_EOL;
    	ob_end_flush();
    }
}