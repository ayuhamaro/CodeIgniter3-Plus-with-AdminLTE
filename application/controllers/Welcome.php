<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_FRONT_Controller {

	public function index()
	{
        $this->load->library('pagination_lib');

        $this->set_view_data('page_title', 'Hi! I\'m '.$this->config->item('site_name'));
        $this->set_view_data('msg', '簡單輕鬆套上全功能版型 & 自動渲染視圖！');


        $page_num = (is_null($this->input->get('page_num')))?'1': $this->input->get('page_num');


        $this->pagination_lib->setting($page_num, 10, 130);
        $pagination_link = $this->pagination_lib->pagination_link();
        $this->set_view_data('pagination_link', $pagination_link);
        $pagination_select = $this->pagination_lib->pagination_select();
        $this->set_view_data('pagination_select', $pagination_select);


        $this->view_content = 'front/welcome/welcome__index';
	}
}
