<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends CI_Controller {

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


	function __construct() {
		parent::__construct();
		$this->load->model("DataModel");
		log_message ("debug", "Model : DataModel is loaded");

	}

	public function logout() {
		$data = ['username', 'password'];
		$this->session->unset_userdata($data);

		redirect('PageController');
	}

	public function index()
	{
		if( is_null($this->session->userdata('username')) || !$this->session->userdata('username') ) 
		{
			$this->session->set_flashdata('flash_data', 'You don\'t have access!');
		}
		$this->load->helper(array('form'));
		$this->load->view('loginPage');
	}

	public function dashboard()
	{

		$this->load->helper(array('form'));
		$this->load->view('dashboard');
	}

	public function scanner()
	{
		$this->load->helper('url');

		$data["getTopScan"] = $this->DataModel->getTopScan();

		$this->load->view("userScan", $data);
	}

    public function getRecentGateTopUp()
    {
        $this->load->helper('url');
        $data2["getGateTopUp"] = $this->DataModel->getGateTopUp();

        $json = json_encode($data2);
        echo $json;
    }




//not used


	function show_list_data()
	{
		// load table library
		$this->load->library('table');
		// set heading
		$this->table->set_heading('image_url', 'ID Number', 'createDate','card_id');
		// set template
		$style = array('table_open'  => '<table class="table table-striped table-hover">');
		$this->table->set_template($style);
		$this->load->model("DataModel");
		$data["getTopGateScan"] = $this->DataModel->getTopGateScan();
		echo $this->table->generate($data["getTopGateScan"]);
	}


	public function broadcast()
	{
		$this->load->helper('url');
		$this->load->view('announcementPage');

	}
	public function ReportDataTable(){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));


			$gateHistoryReport = $this->DataModel->getGateHistoryReport();
			$data = array();

			foreach($gateHistoryReport->result() as $r) {

				$data[] = array(
					$r->studentId,
					$r->card_id,
					$r->firstName,
					$r->lastname
				);
			}

			$output = array(
				"draw" => $draw,
				"recordsTotal" => $gateHistoryReport->num_rows(),
				"recordsFiltered" => $gateHistoryReport->num_rows(),
				"data" => $data
			);
			echo json_encode($output);

	}




    public function ctl_GateHistoryEarlyTimeline(){

        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $x = $this->DataModel->mdl_GateHistoryEarlyTimeline();
        $data = array();

        foreach($x->result() as $r) {

            $data[] = array(
                $r->Time_In,
                $r->Pid,
                $r->Id,
                $r->LastName,
                $r->name,
                $r->category,
                $r->Gate
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $x->num_rows(),
            "recordsFiltered" => $x->num_rows(),
            "data" => $data
        );
        echo json_encode($output);

    }



    public function ctl_gateHistoryLateTimeline(){

        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $x = $this->DataModel->mdl_gateHistoryLateTimeline();
        $data = array();

        foreach($x->result() as $r) {

			$data[] = array(
				$r->Time_In,
				$r->Pid,
				$r->Id,
				$r->LastName,
				$r->name,
				$r->category,
				$r->Gate,
				$r->Cname,
				$r->Number
			);
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $x->num_rows(),
            "recordsFiltered" => $x->num_rows(),
            "data" => $data
        );
        echo json_encode($output);

    }


    public function ctl_GateHistoryTimeline(){

        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $gateHistoryReport = $this->DataModel->mdl_GetGateHistoryTimeline();
        $data = array();

        foreach($gateHistoryReport->result() as $r) {

            $data[] = array(
                $r->Time_In,
                $r->Pid,
                $r->Id,
                $r->LastName,
                $r->name,
                $r->category,
                $r->Gate
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $gateHistoryReport->num_rows(),
            "recordsFiltered" => $gateHistoryReport->num_rows(),
            "data" => $data
        );
        echo json_encode($output);

    }





	public function ReportLateUserDataTable(){

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$gateHistoryReport = $this->DataModel->getLateUserList();
		$data = array();

		foreach($gateHistoryReport->result() as $r) {

			$data[] = array(
				$r->createDate,
				$r->card_id,
				$r->lastName,
				$r->firstName,
				$r->gate_id
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $gateHistoryReport->num_rows(),
			"recordsFiltered" => $gateHistoryReport->num_rows(),
			"data" => $data
		);
		echo json_encode($output);

	}


	public function ctl_ReportAbsentUserDataTable(){

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$gateHistoryReport = $this->DataModel->mdl_ReportAbsentUserDataTable();
		$data = array();

		foreach($gateHistoryReport->result() as $r) {

			$data[] = array(
			    $r->Time_In,
                $r->Pid,
                $r->Id,
                $r->LastName,
                $r->name,
                $r->category,
                $r->Gate


			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $gateHistoryReport->num_rows(),
			"recordsFiltered" => $gateHistoryReport->num_rows(),
			"data" => $data
		);
		echo json_encode($output);

	}


	public function ReportOnTimeUserDataTable(){

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$gateHistoryReport = $this->DataModel->getOnTimeUserList();
		$data = array();

		foreach($gateHistoryReport->result() as $r) {

			$data[] = array(
				$r->createDate,
				$r->card_id,
				$r->lastName,
				$r->firstName,
				$r->gate_id
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $gateHistoryReport->num_rows(),
			"recordsFiltered" => $gateHistoryReport->num_rows(),
			"data" => $data
		);
		echo json_encode($output);

	}









	public function ReportStudentListTable(){

		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$asdf ="asdfasdfa";

		$getStudentListReport = $this->DataModel->getStudentListReport();
		$data = array();

		foreach($getStudentListReport->result() as $r) {

			$data[] = array(
				$r->image_url,
				$r->studentNumber,
				$r->lastname,
				$r->firstname,
				$r->studentType,
				$r->studentstatus,
				$r->Upload
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $getStudentListReport->num_rows(),
			"recordsFiltered" => $getStudentListReport->num_rows(),
			"data" => $data
		);
		echo json_encode($output);

	}

	public function ReportStaffListTable(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$getStaffListReport = $this->DataModel->getStaffListReport();
		$data = array();

		foreach($getStaffListReport->result() as $r) {

			$data[] = array(
				$r->accountID,
				$r->lastname,
				$r->firstname,
				$r->recordstatus
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $getStaffListReport->num_rows(),
			"recordsFiltered" => $getStaffListReport->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
	}


	public function ReportStudentAbsentList(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$getStaffListReport = $this->DataModel->getStudentAbsentList();
		$data = array();

		foreach($getStaffListReport->result() as $r) {

			$data[] = array(
				$r->accountID,
				$r->lastname,
				$r->firstname,
				$r->recordstatus
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $getStaffListReport->num_rows(),
			"recordsFiltered" => $getStaffListReport->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
	}


    public function ctl_ReportGetAllGateUsers(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $getStaffListReport = $this->DataModel->getAllGateUsers();
        $data = array();

        foreach($getStaffListReport->result() as $r) {

            $data[] = array(
                $r->Image,
                $r->Student_ID,
                $r->userGivenId,
                $r->Last_Name,
                $r->Given_Name,
				$r->Middle_Name,
				$r->Suffix,
				$r->Status,
                $r->Gender,
                $r->Birthday,
                $r->Age,
                $r->Category_ID,
                $r->categoryName,
				$r->Card,
                $r->Contact,
                $r->Number,
                $r->Relationship,
                $r->Option

            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $getStaffListReport->num_rows(),
            "recordsFiltered" => $getStaffListReport->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function ctl_getGateUsersForCardAssignment(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $getStaffListReport = $this->DataModel->mdl_getGateUsersForAssignment();
        $data = array();

        foreach($getStaffListReport->result() as $r) {

            $data[] = array(
				$r->ID,
                $r->Card_Number,
                $r->Last_Name,
                $r->Given_Name,
                $r->Category,
                $r->Status
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $getStaffListReport->num_rows(),
            "recordsFiltered" => $getStaffListReport->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function ctl_GetAllUserCategory(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $getStaffListReport = $this->DataModel->mdl_GetAllUserCategory();
        $data = array();

        foreach($getStaffListReport->result() as $r) {

            $data[] = array(
				$r->ID,
                $r->Name,
                $r->Type,
                $r->Time_Setting,
				$r->Absent_Setting,
                $r->Create,
                $r->Date,
				$r->Option
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $getStaffListReport->num_rows(),
            "recordsFiltered" => $getStaffListReport->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
    }


    function ctl_getUserImageTimeline(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $x = $this->DataModel->mdl_getUserImageTimeline();
        $data = array();

        foreach($x->result() as $r) {

            $data[] = array(
                $r->url
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $x->num_rows(),
            "recordsFiltered" => $x->num_rows(),
            "data" => $data
        );
        echo json_encode($output);

    }






    function ctl_GetGuardianList(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $x = $this->DataModel->mdl_GetGuardianList();
        $data = array();

        foreach($x->result() as $r) {

            $data[] = array(
                $r->ID,
                $r->User,
                $r->Type,
                $r->Contact,
                $r->Rel,
                $r->num
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $x->num_rows(),
            "recordsFiltered" => $x->num_rows(),
            "data" => $data
        );
        echo json_encode($output);

    }


    function ctl_MessageTemplateList(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $x = $this->DataModel->mdl_MessageTemplateList();
        $data = array();

        foreach($x->result() as $r) {

            $data[] = array(
                $r->Type,
                $r->Text,
                $r->By,
                $r->date
            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $x->num_rows(),
            "recordsFiltered" => $x->num_rows(),
            "data" => $data
        );
        echo json_encode($output);

    }



	function ctl_GetMsgTemplateList(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$x = $this->DataModel->mdl_GetMsgTemplateList();
		$data = array();

		foreach($x->result() as $r) {

			$data[] = array(
                $r->Id,
				$r->Type,
				$r->Text,
				$r->By,
				$r->date
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $x->num_rows(),
			"recordsFiltered" => $x->num_rows(),
			"data" => $data
		);
		echo json_encode($output);

	}





    public function absentees()
    {
        $this->load->helper('url');
        $this->load->view('reportPageAbsentees');
    }

    public function imageHistoryBar()
    {
        $this->load->helper('url');
        $this->load->view('GateImageHistory');
    }

    public function sysSettings()
    {
        $this->load->helper('url');
        $this->load->view('settingsPage');
    }

    public function ipSettings()
    {
        $this->load->helper('url');
        $this->load->view('ipPage');
    }


    public function guardianList()
    {
        $this->load->helper('url');
        $this->load->view('guardianPage');
    }

	public function reporting()
	{
		$this->load->helper('url');
		$this->load->view('reportPage');
	}

	public function reporting_late()
	{
		$this->load->helper('url');
        $data['msg'] = $this->DataModel->getAllMsgType();
		$this->load->view('reportLatePage', $data);
	}

    public function UserCategoryList()
    {
        $this->load->helper('url');
        $this->load->view('UserCategoryListPage');
    }

	public function reporting_onTime()
	{
		$this->load->helper('url');
		$this->load->view('reportOnTimePage');
	}


    public function cardList()
    {

        $this->load->helper('url');
        $this->load->view('cardUserPage');
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

	public function admin()
	{
		$this->load->helper('url');
		$this->load->view('adminPage');

	}


	public function msgTemplates()
	{
		$this->load->helper('url');
		$this->load->view('msgTemplatePage');

	}


	public function uploadTry(){

		$this->load->view('uploadTry', array('error'=>''));

	}

    public function station(){
        $this->load->helper('url');
        $this->load->view('scanningStation');

    }

    public function gate(){
        $this->load->helper('url');
		$this->load->view('gateStation');
    }

    public function ErrorPage(){
        $this->load->helper('url');
        $this->load->view('error_page');

    }

	public function test(){
		$this->load->helper('url');
		$this->load->view('userScan');

	}
//Iframe in gateScanner
    public function loader(){
        $this->load->helper('url');
        $this->load->view('load_frame');

    }




















}

