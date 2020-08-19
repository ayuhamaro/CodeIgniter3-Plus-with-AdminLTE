<div class="row">
    <div class="col-12">
        <h1><?php echo $msg; ?></h1>
        <br>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 col-xl-5">
        <?php echo $pagination_link; ?>
    </div>
    <div class="col-12 col-lg-5 col-xl-4">
        <?php echo $pagination_select; ?>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <br>
        <span>控制器：application\controllers\Welcome.php</span>
        <pre>
            <code>
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
            </code>
        </pre>
        <span>視圖：application\views\front\welcome\welcome__index.php</span>
        <pre>
            <code>
<?php
$str = <<<EOD
<div class="row">
    <div class="col-12">
        <h1><?php echo \$msg; ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 col-xl-5">
        <?php echo \$pagination_link; ?>
    </div>
    <div class="col-12 col-lg-5 col-xl-4">
        <?php echo \$pagination_select; ?>
    </div>
</div>
EOD;
echo htmlspecialchars($str);
?>
            </code>
        </pre>
        <span>這樣就完成囉！</span>
    </div>
</div>