<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index() {
        $viewData['title'] = '页面列表';
        $this->assign($viewData)->display();
    } 
}