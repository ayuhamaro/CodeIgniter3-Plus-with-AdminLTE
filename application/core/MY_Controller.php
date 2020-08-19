<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

class MY_ADMIN_Controller extends CI_Controller
{
    /*傳送到view的資料陣列，為了讓MY_Controller能以權限機制操控，而宣告在這裡提供繼承*/
    private  $view_data = array(
        'site_name' => NULL,
        'site_title' => NULL,
        'page_title' => NULL,
        'page_uri' => NULL,
        'query_string' => NULL,
        'return_uri' => NULL,
        'error_msg' => NULL,
        'layout_options' => 'sidebar-mini layout-fixed',
    );
    /*view的各版面區塊設定*/
    protected $view_base = 'template/admin/page_base';
    protected $view_metadata = NULL;
    protected $view_common_js = 'template/admin/common_js';
    protected $view_js = NULL;
    protected $view_common_css = 'template/admin/common_css';
    protected $view_css = NULL;
    protected $view_header = 'template/admin/header';
    protected $view_content_header = 'template/admin/content_header';
    protected $view_content_footer = 'template/admin/content_footer';
    protected $view_left_side = 'template/admin/left_side';
    protected $view_right_side = 'template/admin/right_side';
    protected $view_error_msg = 'template/admin/error_msg';
    protected $view_content = 'template/admin/content';
    protected $view_footer = 'template/admin/footer';
    protected $view_extra = 'template/admin/extra';
    protected $view_common_nle_js = 'template/admin/common_nle_js';
    protected $view_nle_js = NULL;
    protected $view_common_nle_css = 'template/admin/common_nle_css';
    protected $view_nle_css = NULL;

    /*無須登入即可使用的URI*/
    private $exclude_login_uri = array(
        'admin/login',
        'admin/no_permission',
    );

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->load->helper('url');

        $this->view_data['page_uri'] = ( ! isset($_SERVER['PATH_INFO']))? '/': $_SERVER['PATH_INFO'];
        $this->view_data['query_string'] = ( ! isset($_SERVER['QUERY_STRING']))? '': $_SERVER['QUERY_STRING'];

        //session_set_cookie_params(86400, '/', $this->config->item('cookie_domain'), FALSE, TRUE);
        if( ! session_id())
        {
            session_start();
        }

        //$this->_login_check('/admin/login');
        //$this->_permission();
    }

    public function __destruct()
    {
        echo $this->render();
    }

    protected function set_view_data($attr, $value)
    {
        $this->view_data[$attr] = $value;
    }

    protected function get_view_data($attr = NULL)
    {
        if( ! is_null($attr) && isset($this->view_data[$attr]))
        {
            return $this->view_data[$attr];
        }
        else
        {
            return $this->view_data;
        }
    }

    private function _permission()
    {
        /*不須登入的頁面無須權限控管*/
        if(in_array($this->uri->uri_string(), $this->exclude_login_uri))
        {
            return NULL;
        }

        /*各樣特別的權限檢查*/
        if(isset($_SESSION['login_info']) && is_array($_SESSION['login_info']))
        {

        }

    }

    private function _login_check($login_ctrl = 'login')
    {
        /*指定URI不做登入檢查*/
        if(in_array($this->uri->uri_string(), $this->exclude_login_uri))
        {
            return NULL;
        }

        /*如果沒有Session的登入資訊，則導到登入頁*/
        if( ! isset($_SESSION['login_info']))
        {
            redirect($login_ctrl);
        }
    }

    protected function render()
    {
        if( ! isset($this->view_data['layout_options']) OR is_null($this->view_data['layout_options']))
        {
            $this->view_data['layout_options'] = 'sidebar-mini layout-fixed';
        }

        $this->view_data['site_name'] = $this->config->item('site_name');
        if( ! isset($this->view_data['page_title']) OR is_null($this->view_data['page_title']))
        {
            $this->view_data['site_title'] = $this->config->item('site_name');
        }
        else
        {
            $this->view_data['site_title'] = $this->config->item('site_name').'-'.$this->view_data['page_title'];
        }
        if( ! isset($this->view_data['error_msg']) OR is_null($this->view_data['error_msg']))
        {
            $this->view_data['error_msg'] = NULL;
        }

        $view_config = array(
            'metadata' => (is_string($this->view_metadata))? $this->load->view($this->view_metadata, $this->view_data, TRUE): "\r\n",
            'common_js' => (is_string($this->view_common_js))? $this->load->view($this->view_common_js, $this->view_data, TRUE): "\r\n",
            'js' => (is_string($this->view_js))? $this->load->view($this->view_js, $this->view_data, TRUE): "\r\n",
            'common_css' => (is_string($this->view_common_css))? $this->load->view($this->view_common_css, $this->view_data, TRUE): "\r\n",
            'css' => (is_string($this->view_css))? $this->load->view($this->view_css, $this->view_data, TRUE): "\r\n",
            'header' => (is_string($this->view_header))? $this->load->view($this->view_header, $this->view_data, TRUE): "\r\n",
            'content_header' => (is_string($this->view_content_header))? $this->load->view($this->view_content_header, $this->view_data, TRUE): "\r\n",
            'content_footer' => (is_string($this->view_content_footer))? $this->load->view($this->view_content_footer, $this->view_data, TRUE): "\r\n",
            'left_side' => (is_string($this->view_left_side))? $this->load->view($this->view_left_side, $this->view_data, TRUE): "\r\n",
            'right_side' => (is_string($this->view_right_side))? $this->load->view($this->view_right_side, $this->view_data, TRUE): "\r\n",
            'error_msg' => (is_string($this->view_error_msg))? $this->load->view($this->view_error_msg, $this->view_data, TRUE): "\r\n",
            'content' => (is_string($this->view_content))? $this->load->view($this->view_content, $this->view_data, TRUE): "\r\n",
            'footer' => (is_string($this->view_footer))? $this->load->view($this->view_footer, $this->view_data, TRUE): "\r\n",
            'extra' => (is_string($this->view_extra))? $this->load->view($this->view_extra, $this->view_data, TRUE): "\r\n",
            'common_nle_js' => (is_string($this->view_common_nle_js))? $this->load->view($this->view_common_nle_js, $this->view_data, TRUE): "\r\n",
            'nle_js' => (is_string($this->view_nle_js))? $this->load->view($this->view_nle_js, $this->view_data, TRUE): "\r\n",
            'common_nle_css' => (is_string($this->view_common_nle_css))? $this->load->view($this->view_common_nle_css, $this->view_data, TRUE): "\r\n",
            'nle_css' => (is_string($this->view_nle_css))? $this->load->view($this->view_nle_css, $this->view_data, TRUE): "\r\n",
        );
        $this->view_data['___VIEW_HTML___'] = $view_config;
        return $this->load->view($this->view_base, $this->view_data, TRUE);
    }

}

class MY_FRONT_Controller extends CI_Controller
{
    /*傳送到view的資料陣列，為了讓MY_Controller能以權限機制操控，而宣告在這裡提供繼承*/
    private  $view_data = array(
        'site_name' => NULL,
        'site_title' => NULL,
        'page_title' => NULL,
        'page_uri' => NULL,
        'query_string' => NULL,
        'return_uri' => NULL,
        'error_msg' => NULL,
        'layout_options' => 'sidebar-mini layout-fixed',
    );
    /*view的各版面區塊設定*/
    protected $view_base = 'template/front/page_base';
    protected $view_metadata = NULL;
    protected $view_common_js = 'template/front/common_js';
    protected $view_js = NULL;
    protected $view_common_css = 'template/front/common_css';
    protected $view_css = NULL;
    protected $view_header = 'template/front/header';
    protected $view_content_header = 'template/front/content_header';
    protected $view_content_footer = 'template/front/content_footer';
    protected $view_left_side = 'template/front/left_side';
    protected $view_right_side = 'template/front/right_side';
    protected $view_error_msg = 'template/front/error_msg';
    protected $view_content = 'template/front/content';
    protected $view_footer = 'template/front/footer';
    protected $view_extra = 'template/front/extra';
    protected $view_common_nle_js = 'template/front/common_nle_js';
    protected $view_nle_js = NULL;
    protected $view_common_nle_css = 'template/front/common_nle_css';
    protected $view_nle_css = NULL;

    /*無須登入即可使用的URI*/
    private $exclude_login_uri = array(
        'admin/login',
        'admin/no_permission',
    );

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->load->helper('url');

        $this->view_data['page_uri'] = ( ! isset($_SERVER['PATH_INFO']))? '/': $_SERVER['PATH_INFO'];
        $this->view_data['query_string'] = ( ! isset($_SERVER['QUERY_STRING']))? '': $_SERVER['QUERY_STRING'];

        //session_set_cookie_params(86400, '/', $this->config->item('cookie_domain'), FALSE, TRUE);
        if( ! session_id())
        {
            session_start();
        }

        //$this->_login_check('/admin/login');
        //$this->_permission();
    }

    public function __destruct()
    {
        echo $this->render();
    }

    protected function set_view_data($attr, $value)
    {
        $this->view_data[$attr] = $value;
    }

    protected function get_view_data($attr = NULL)
    {
        if( ! is_null($attr) && isset($this->view_data[$attr]))
        {
            return $this->view_data[$attr];
        }
        else
        {
            return $this->view_data;
        }
    }

    private function _permission()
    {
        /*不須登入的頁面無須權限控管*/
        if(in_array($this->uri->uri_string(), $this->exclude_login_uri))
        {
            return NULL;
        }

        /*各樣特別的權限檢查*/
        if(isset($_SESSION['login_info']) && is_array($_SESSION['login_info']))
        {

        }

    }

    private function _login_check($login_ctrl = 'login')
    {
        /*指定URI不做登入檢查*/
        if(in_array($this->uri->uri_string(), $this->exclude_login_uri))
        {
            return NULL;
        }

        /*如果沒有Session的登入資訊，則導到登入頁*/
        if( ! isset($_SESSION['login_info']))
        {
            redirect($login_ctrl);
        }
    }

    protected function render()
    {
        if( ! isset($this->view_data['layout_options']) OR is_null($this->view_data['layout_options']))
        {
            $this->view_data['layout_options'] = 'sidebar-mini layout-fixed';
        }

        $this->view_data['site_name'] = $this->config->item('site_name');
        if( ! isset($this->view_data['page_title']) OR is_null($this->view_data['page_title']))
        {
            $this->view_data['site_title'] = $this->config->item('site_name');
        }
        else
        {
            $this->view_data['site_title'] = $this->config->item('site_name').'-'.$this->view_data['page_title'];
        }
        if( ! isset($this->view_data['error_msg']) OR is_null($this->view_data['error_msg']))
        {
            $this->view_data['error_msg'] = NULL;
        }

        $view_config = array(
            'metadata' => (is_string($this->view_metadata))? $this->load->view($this->view_metadata, $this->view_data, TRUE): "\r\n",
            'common_js' => (is_string($this->view_common_js))? $this->load->view($this->view_common_js, $this->view_data, TRUE): "\r\n",
            'js' => (is_string($this->view_js))? $this->load->view($this->view_js, $this->view_data, TRUE): "\r\n",
            'common_css' => (is_string($this->view_common_css))? $this->load->view($this->view_common_css, $this->view_data, TRUE): "\r\n",
            'css' => (is_string($this->view_css))? $this->load->view($this->view_css, $this->view_data, TRUE): "\r\n",
            'header' => (is_string($this->view_header))? $this->load->view($this->view_header, $this->view_data, TRUE): "\r\n",
            'content_header' => (is_string($this->view_content_header))? $this->load->view($this->view_content_header, $this->view_data, TRUE): "\r\n",
            'content_footer' => (is_string($this->view_content_footer))? $this->load->view($this->view_content_footer, $this->view_data, TRUE): "\r\n",
            'left_side' => (is_string($this->view_left_side))? $this->load->view($this->view_left_side, $this->view_data, TRUE): "\r\n",
            'right_side' => (is_string($this->view_right_side))? $this->load->view($this->view_right_side, $this->view_data, TRUE): "\r\n",
            'error_msg' => (is_string($this->view_error_msg))? $this->load->view($this->view_error_msg, $this->view_data, TRUE): "\r\n",
            'content' => (is_string($this->view_content))? $this->load->view($this->view_content, $this->view_data, TRUE): "\r\n",
            'footer' => (is_string($this->view_footer))? $this->load->view($this->view_footer, $this->view_data, TRUE): "\r\n",
            'extra' => (is_string($this->view_extra))? $this->load->view($this->view_extra, $this->view_data, TRUE): "\r\n",
            'common_nle_js' => (is_string($this->view_common_nle_js))? $this->load->view($this->view_common_nle_js, $this->view_data, TRUE): "\r\n",
            'nle_js' => (is_string($this->view_nle_js))? $this->load->view($this->view_nle_js, $this->view_data, TRUE): "\r\n",
            'common_nle_css' => (is_string($this->view_common_nle_css))? $this->load->view($this->view_common_nle_css, $this->view_data, TRUE): "\r\n",
            'nle_css' => (is_string($this->view_nle_css))? $this->load->view($this->view_nle_css, $this->view_data, TRUE): "\r\n",
        );
        $this->view_data['___VIEW_HTML___'] = $view_config;
        return $this->load->view($this->view_base, $this->view_data, TRUE);
    }

}

class MY_AJAX_Controller extends CI_Controller
{
    protected $view_data = array(
        'success' => FALSE,
        'statusCode' => '1000',
        'errorMsg' => 'Not logged in',
    );

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();

        //session_set_cookie_params(86400, '/', $this->config->item('cookie_domain'), FALSE, TRUE);
        if( ! session_id())
        {
            session_start();
        }

        //$this->_login_check();
    }

    public function __destruct()
    {
        echo $this->ajax_output();
    }

    private function _login_check()
    {
        /*如果沒有Session的登入資訊，則傳回指定錯誤*/
        if( ! isset($_SESSION['login_info']))
        {
            /*在建構器使用exit時，無法使用視圖，所以直接輸出JSON*/
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->view_data);
            exit;
        }
    }

    protected function ajax_output()
    {
        return $this->load->view('api/ajax', array('json' => json_encode($this->view_data)), TRUE);
    }

}

class MY_CLI_Controller extends CI_Controller
{
    private $view_data = array(
        'msg' => 'The controller use at CLI only',
    );

    public function __construct()
    {
        parent::__construct();

        if( ! is_cli())
        {
            echo "本控制器只可用於命令列環境";
            exit;
        }

        //$this->load->database();
    }

    public function __destruct()
    {
        if(is_cli())
        {
            echo $this->cli_output();
        }
    }

    protected function set_view_data($attr, $value)
    {
        $this->view_data[$attr] = $value;
    }

    protected function get_view_data($attr = NULL)
    {
        if( ! is_null($attr) && isset($this->view_data[$attr]))
        {
            return $this->view_data[$attr];
        }
        else
        {
            return $this->view_data;
        }
    }

    protected function cli_output()
    {
        return $this->load->view('cli/cli', $this->view_data, TRUE);
    }

}

class MY_Lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }


}