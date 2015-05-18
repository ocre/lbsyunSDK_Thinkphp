<?php
/**
 * Geo API 基础类
 * 2015年5月
 * author ocre
 */
namespace Common\ORG;
use Common\ORG\Http;
abstract class GeoApiBase {
	const MAP_API_HTTP              = "http://api.map.baidu.com";
	
	private $_ak; // access key
	private $_sk; // security key
	private $_error;
	private $_result;
	private $_http;

	public function __construct($options = array()) {
		$this->_ak = isset($options['ak'])        ? $options['ak']        : '';
		$this->_sk = isset($options['sk'])        ? $options['sk']        : '';
		$this->_http = new Http($options);
	}
	/**
	 * 捕获响应结果
	 * @return array 响应结果 
	 */
	public function getResult() {
		return $this->_result;
	}
	/**
	 * 捕获错误信息
	 * @return string 中文错误信息
	 * @author 、小陈叔叔 <cjango@163.com>
	 */
	public function getError() {
		return $this->_error;
	}
	/**
	 * GET请求
	 * @param string $uri 接口uri
	 * @param array  $params 接口参数
	 * @return string 接口返回文本
	 */
	protected function _apiGet($uri, $params) {
		$params['ak'] = $this->_ak;
		$sn = $this->_caculateSn($uri, $params);
		$target = self::MAP_API_HTTP . $uri . '?' . http_build_query($params) . '&sn=' . $sn;
		$jsonStr = $this->_http->http($target);
		return $this->_parseJson($jsonStr);
	}
	/**
	 * POST请求
	 * @param string $uri 接口uri
	 * @param array  $params 接口参数
	 * @return string 接口返回文本
	 */
	protected function _apiPost($uri, $params) {
		$params['ak'] = $this->_ak;
		ksort($params);
		$sn = $this->_caculateSn($uri, $params);
		$target = self::MAP_API_HTTP . $uri;
		$params['sn'] = $sn;
		$jsonStr = $this->_http->http($target, $params, 'POST');
		return $this->_parseJson($jsonStr);
	}
	/**
	 * 上传文件
	 * @param string $uri 接口uri
	 * @param array  $params 接口参数
	 * @param array  $params 文件列表
	 * @return string 接口返回文本
	 */
	protected function _apiPostFile($uri, $params, $files) {
		$params['ak'] = $this->_ak;
		ksort($params);
		$sn = $this->_caculateSn($uri, $params);
		$target = self::MAP_API_HTTP . $uri;
		$params = array_merge($params, $files);
		$params['sn'] = $sn;
		$jsonStr = $this->_http($target, $params, 'POST');
		return $this->_parseJson($jsonStr);
	}
	/**
	 * 计算sn
	 * @param json $json json数据
	 * @return array
	 */
	private function _caculateSn($url, $querystring_arrays) {
		$querystring = http_build_query($querystring_arrays);
		return md5(urlencode($url.'?'.$querystring.$this->_sk));
	}
	/**
	 * 解析JSON编码，如果有错误，则返回错误并设置错误信息
	 * @param json $json json数据
	 * @return array
	 * @author 、小陈叔叔 <cjango@163.com>
	 */
	private function _parseJson($json) {
		$this->_error = null;
		$this->_result = null;
		$jsonArr = json_decode($json, true);
		if (isset($jsonArr['status'])) {
			if ($jsonArr['status'] == 0) {
				$this->_result = $jsonArr;
				return true;
			} else {
				$this->_error = $jsonArr['message'];
				return false;
			}
		}else {
			$this->_result = $jsonArr;
			return true;
		}
	}
}
