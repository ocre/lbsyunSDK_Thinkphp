<?php
namespace Home\Controller;
use Think\Controller;
use Common\ORG\GeoSearch;
class HospitalController extends Controller {
    private $_geoObj;

    public function _initialize() {
        $options = array(
            'ak' => C('LBSYUN_AK'),
            'sk' => C('LBSYUN_SK'),
        );
        $this->_geoObj = new GeoSearch($options);
    }
    /**
     * 查询附近的医院，按距离由近及远排序
     *
     */
    public function around() {
        $limit = 10;
        $page = new \Think\Page(1000000, $limit);
        $page->show();
        $page_index = $page->nowPage - 1;
    	$position = array(
            'latitude' => 39.93242,
            'longitude' => 116.403335,
        );
        $longitude = $position['longitude'];
        $latitude = $position['latitude'];
        $tableId = C('LBSYUN_HOSPITAL_TABLE_ID');
        $query['location'] = $longitude . ',' . $latitude;
        $query['radius'] = 2000000;
        $query['page_index'] = $page_index;
        $query['page_size'] = $limit;
        $result = $this->_geoObj->nearby($tableId, $query);
        if ($result == false) {
            $this->error('查询失败' . $this->_geoObj->getError());
        }
        $count = $result['total'];
        $page = new \Think\Page($count, $limit);
        $page->show();

        $hospitals = array();
        $hospitalids = array();
        foreach ($result['contents'] as $key => $value) {
            $hospital = $value;
            $hospital['id'] = $hospital['hospital_id'];
            $hospital['name'] = $hospital['hospital_name'];
            $hospital['distance'] = show_distance(ceil($value['distance']));
            $hospitals[] = $hospital;
            $hospitalids[] = $hospital['id'];
        }
        $viewData['results'] = $hospitals;
        $viewData['nowPage'] = $page->nowPage;
        $viewData['hasNextPage'] = ($page->totalPages > $page->nowPage) ? 1 : 0;
        if (IS_AJAX) {
            $this->ajaxReturn($viewData);
        } else {
            $viewData['title'] = '附近医院';
            $this->assign($viewData)->display();
        }
    }
}