<?php
function show_doc_degree(int $degree){
	switch ($degree) {
		case 1:
		return '博士';
		case 2:
		return '硕士';
		case 3:
		return '学士';
		default:
		return '';
	}
}

function show_sex(int $sex) {
	return ($sex == 1) ? '男' : '女';
}

function show_bool(int $bool, $term) {
	$bool = $bool != 0;
	if ($bool) {
		return empty($term) ? '是' : $term;
	} else {
		return empty($term) ? '否' : '不'.$term;
	}
}

function show_distance($meters) {
	if ($meters < 100) {
		return '&lt;' . $meters . '米';
	} else if ($meters >= 100 && $meters < 1000) {
		return $meters . '米';
	} else if ($meters >= 1000) {
		$value = sprintf("%0.1f", $meters / 1000);
		$value = str_replace('.0', '', $value);
		return $value . '公里';
	}
}

function split_first($str, $delim = ',') {
	$segments = explode($delim, $str, 1);
	return $segments[0];
}
 /**
 * 获取当前页面完整URL地址
 */
 function get_url() {
 	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
 	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
 	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
 	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
 	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
 }
 ?>