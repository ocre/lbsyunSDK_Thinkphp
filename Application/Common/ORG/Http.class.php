<?php
/**
 * 通用http请求类
 * 需要有 CURL 支持
 * 2015年5月
 * original author 小陈叔叔 <cjango@163.com>
 * copy & modified from http://git.oschina.net/cjango
 */
namespace Common\ORG;

class Http {
	private $_pem; // ssl cert name
	private $_pemPath; // ssl cert path
	private $_error;

	public function __construct($options = array()) {
		$this->_pem = isset($options['pem']) ? $options['pem'] : 'pem';
		$this->_pemPath = isset($options['pemPath']) ? $options['pemPath'] : (dirname(__FILE__) . '/');
	}
	/**
	 * 发送HTTP请求方法，目前只支持CURL发送请求
	 * @param  string  $url    请求URL
	 * @param  array   $params 请求参数
	 * @param  string  $method 请求方法GET/POST
	 * @param  boolean $ssl    是否进行SSL双向认证
	 * @return array   $data   响应数据
	 * @author 、小陈叔叔 <cjango@163.com>
	 */
	public function http($url, $params = array(), $method = 'GET', $ssl = false){
		$opts = array(
				CURLOPT_TIMEOUT        => 30,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
		);
		/* 根据请求类型设置特定参数 */
		switch(strtoupper($method)){
			case 'GET':
				$opts[CURLOPT_URL] = $url . (empty($params) ? '' : '?' . http_build_query($params));
				break;
			case 'POST':
				$opts[CURLOPT_URL] = $url;
				$opts[CURLOPT_POST] = 1;
				$opts[CURLOPT_POSTFIELDS] = $params;
				break;
		}
		if ($ssl) {
			$pemCret = $this->_pemPath.$this->_pem.'_cert.pem';
			$pemKey  = $this->_pemPath.$this->_pem.'_key.pem';
			if (!file_exists($pemCret)) {
				$this->error = '证书文件' . $pemCret . '不存在';
				return false;
			}
			if (!file_exists($pemKey)) {
				$this->error = '密钥文件' . $pemKey . '不存在';
				return false;
			}
			$opts[CURLOPT_SSLCERTTYPE] = 'PEM';
			$opts[CURLOPT_SSLCERT]     = $pemCret;
			$opts[CURLOPT_SSLKEYTYPE]  = 'PEM';
			$opts[CURLOPT_SSLKEY]      = $pemKey;
		}
		/* 初始化并执行curl请求 */
		$ch = curl_init();
		curl_setopt_array($ch, $opts);
		$data  = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		curl_close($ch);
		if ($err > 0) {
			$this->error = $errmsg;
			return false;
		}else {
			return $data;
		}
	}
}