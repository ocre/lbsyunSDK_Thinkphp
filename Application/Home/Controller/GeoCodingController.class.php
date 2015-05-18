<?php
namespace Home\Controller;
use Think\Controller;
use Common\ORG\GeoCoding;
class GeoCodingController extends Controller {
	private $_geoObj;

	public function _initialize() {
		$options = array(
			'ak' => C('LBSYUN_AK'),
			'sk' => C('LBSYUN_SK'),
		);
        $this->_geoObj = new GeoCoding($options);
    }
    /**
     * 测试代码：通过地址获取坐标
     *
     */
	public function testGetCoord($address, $city = null) {
		$result = $this->_geoObj->getCoord($address, $city);
		if ($result) {
			echo json_encode($result['result']);
		}else {
			echo false;
		}
	}
    /**
     * 根据医院详细地址设置医院的坐标。
     *
     */
    public function setHospitalCoords() {
    	set_time_limit(1800);
    	if (ob_get_level() == 0) ob_start();
    	$count = 0;
    	$model = M('Hospital');
    	$data = $model->select();
    	foreach ($data as $key => $hospital) {
    		$address = $hospital['address'];
    		$city = $hospital['city'];
    		$result = $this->_geoObj->getCoord($address, $city);
    		if ($result) {
    			$lat = $result['result']['location']['lat'];
    			$lng = $result['result']['location']['lng'];
    			$saveData = array(
    				'latitude' => $lat,
    				'longitude' => $lng,
    			);
    			$model->where(array('id'=>$hospital['id']))->save($saveData);
    			$count++;
    			if ($count % 10 == 0) {
    				echo $count . ' records updated.' . PHP_EOL;
    				ob_flush();
    				flush();
    			}
    		}
    	}
    	echo 'all done! ' . $count . ' records updated.' . PHP_EOL;
    	ob_end_flush();
    }
}