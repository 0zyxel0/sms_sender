<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		#echo"trial";
	}


	public function index()
	{

		$this->load->helper(array('form'));
		$this->load->view('loginPage');
	}

	public function scanner()
	{
		$this->load->helper('url');
		$this->load->view('userScan');

	}

	public function broadcast()
	{
		$this->load->helper('url');
		$this->load->view('announcementPage');

	}

	public function reporting()
	{
		$this->load->helper('url');
		$this->load->view('reportPage');

	}

	public function visiting()
	{

		$this->load->helper('url');
		$this->load->view('visitorPage');
	}

	public function staffs()
	{

		$this->load->helper('url');
		$this->load->view('staffPage');
	}

	public function students()
	{

		$this->load->helper('url');
		$this->load->view('studentPage');
	}





}
