<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class LoginController extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model("Login_Model", "login");
        if(!empty($_SESSION['id_user']))
            redirect('Pagecontroller/index');
    }

    public function index() {
        if($_POST) {
            $result = $this->login->validate_user($_POST);
            if(!empty($result)) {
                $data = [
                    'username' => $result->username,
                    'password' => $result->password
                ];

                $this->session->set_userdata($data);
                if($data['username'] == 'SmsAdmin'){
                    redirect('PageController/sysSettings');
                }else{
                    $this->session->set_flashdata('flash_data', 'Username or password is wrong!');
                    redirect('Pagecontroller/index');
                }


            } else {
                $this->session->set_flashdata('flash_data', 'Username or password is wrong!');
                redirect('Pagecontroller/index');
            }
        }

        $this->load->view("Pagecontroller/index");
    }
}