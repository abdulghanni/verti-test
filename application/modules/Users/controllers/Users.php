<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {
    public $data;
    var $module = 'users';
    var $title = 'Users';
    var $file_name = 'users';
    var $table_name = '';
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('curl');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->data['data'] = $data = json_decode($this->curl->simple_get('http://jsonplaceholder.typicode.com/users'));
        $this->_render_page($this->file_name.'/index', $this->data);
    }

    public function detail($id)
    {
        $this->data['data'] = $data = json_decode($this->curl->simple_get('http://jsonplaceholder.typicode.com/users/'.$id));
        // print_r($data);
        echo $data->name;
        // foreach ($data as $k) {
        //     // echo $k['name'];
        // }
        // die();
        $this->_render_page($this->file_name.'/detail', $this->data);
    }

    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

                if(in_array($view, array($this->file_name.'/index')))
                {
                    $this->template->set_layout('default'); 
                     $this->template->add_css($this->module.'/dashboard.css?v4.0.1'); 
                     $this->template->add_plugin_css('slidepanel/slidepanel.minfd53.css?v4.0.1'); 
                     
                     // $this->template->add_plugin_css('datatables.net-bs/css/dataTables.bootstrap.min.css'); 
                    
                    // $this->template->add_plugin_js('datatables.net-buttons/js/dataTables.buttons.min.js');
                }

            if ( ! empty($data['title']))
            {
                $this->template->set_title($data['title']);
            }

            $this->template->load_view($view, $data);
        }
        else
        {
            return $this->load->view($view, $data, TRUE);
        }
    }
}
