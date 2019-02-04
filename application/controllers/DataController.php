<?php

class DataController extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('DataModel');
    }
    //Not Being Used
    /*function uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $parts = [substr($chars,0,8), substr($chars,8,4), substr($chars,12,4), substr($chars,16,4), substr($chars,20,12)];

        return $prefix . implode($parts, '-');;
    }*/
    //End


    function generateCategoryData(){




        $this->load->helper('url');
        $data['category'] = $this->DataModel->getAllCategory();

        $json = json_encode($data);
        echo $json;
    }




    function AddAssignNumber() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('stdNumb','Mobile No.' ,'required');
        $this->form_validation->set_rules('formPutSerial', 'Mobile No.','required');
        $this->form_validation->set_rules('userCategory', 'Mobile No.',
            'required');
        $this->form_validation->set_rules('cardStat', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/admin'));
            } else {
            $data = array(
                'partyid' => $this->input->post('stdNumb'),
                'card_id' => $this->input->post('formPutSerial'),
                'userCatId' => $this->input->post('userCategory'),
                'createdBy' => $this->session->userdata('username'),
                'isDisabled' => $this->session->post('cardStat'),
                'createDate' => date('Y-m-d H:i:s')
            );

            $this->DataModel->saveAssignNumber($data);//Transfering data to Model
            $data['message'] = 'Data Inserted Successfully';

            redirect(site_url('PageController/admin'));
        }
    }


    function ctl_AssignCardToUser() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('post_partyid','Mobile No.' ,'required');
        $this->form_validation->set_rules('post_cardId', 'Mobile No.','required');
        $this->form_validation->set_rules('post_userType', 'Mobile No.','required');
        $this->form_validation->set_rules('post_isDisabled','Mobile No.' ,'required');
        $cardId = $this->input->post('post_cardId');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $postData = array(
                'partyId' => $this->input->post('post_partyid'),
                'card_id' => $cardId,
                'categoryId' => $this->input->post('post_userType'),
                'createdBy' => $this->session->userdata('username'),
                'createDate' => date('Y-m-d H:i:s'),
                'updateDate' => date('Y-m-d H:i:s'),
                'isDisabled' => $this->input->post('post_isDisabled')
            );

            $this->DataModel->assignCardToUser($postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';

            $postData2 = array(
                'card_id' => $cardId,
                'campus_status'=>"",
                'gate_id'=> "",
                'updatedate' =>date('Y-m-d H:i:s'),
            );
            $this->DataModel->mdl_AddGatePersonStatus($postData2);

            redirect(site_url('PageController/ActiveUsers'));
        }
    }







    function AddGateUserCategory() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('catType','Mobile No.' ,'required');
        $this->form_validation->set_rules('catName', 'Mobile No.','required');
        $this->form_validation->set_rules('catTime', 'Mobile No.','required');
        $this->form_validation->set_rules('absTime', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $postData = array(
                'categoryName' => $this->input->post('catName'),
                'categoryType' => $this->input->post('catType'),
                'gateTimeInSetting' => $this->input->post('catTime'),
                'gateTimeSettingAbsent' => $this->input->post('absTime'),
                'createdBy' => $this->session->userdata('username'),
                'updateDate' => date('Y-m-d H:i:s')
            );

            $this->DataModel->insertNewUserCategory($postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';

            redirect(site_url('PageController/UserCategoryList'));
        }
    }


    function ctl_editGateUserCategory() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('edit_catID','Mobile No.' ,'required');

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {

                 $Id = $this->input->post('edit_catID');
                 $v1 = $this->input->post('edit_catName');
                 $v2 = $this->input->post('edit_catType');
                 $v3 = $this->input->post('edit_catTime');
                 $v4 = $this->input->post('edit_catAbsentTime');
                 $update =date('Y-m-d H:i:s');

            $this->DataModel->mdl_editGateUserCategory($Id, $v1,$v2,$v3,$v4, $update);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';

            redirect(site_url('PageController/UserCategoryList'));
        }
    }


    function ctl_deleteGateUserCategory() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('dlt_catID','Mobile No.' ,'required');

        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {

            $Id = $this->input->post('dlt_catID');

            $this->DataModel->mdl_deleteGateUserCategory($Id);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';

            redirect(site_url('PageController/UserCategoryList'));
        }
    }


    function rolekey_exists()
    {
        if(!filter_var($_POST["key"]))
        {
            echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> Invalid Email</span></label>';
        }
        else
        {
            $this->load->model("DataModel");
            if($this->DataModel->userId_exists($_POST["key"]))
            {
                echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> ID Already register</label>';
            }
            else
            {
                echo '<label class="text-success"><span class="glyphicon glyphicon-ok"></span> ID Available</label>';
            }
        }
    }





    function createNewRecordPerson(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('record_lastName','Mobile No.' ,'required');
        $this->form_validation->set_rules('record_givenName','Mobile No.' ,'required');
        $this->form_validation->set_rules('record_middleName','Mobile No.' ,'required');
        $this->form_validation->set_rules('slt_CivilStatus','Mobile No.' ,'required');
        $this->form_validation->set_rules('slt_Gender','Mobile No.' ,'required');


        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $postData = array(
                'userGivenId' => $this->input->post('record_existingUserID'),
                'familyname' => $this->input->post('record_lastName'),
                'givenname' => $this->input->post('record_givenName'),
                'middlename' => $this->input->post('record_middleName'),
                'suffix' => $this->input->post('record_suffix'),
                'civilStatus' => $this->input->post('slt_CivilStatus'),
                'gender' => $this->input->post('slt_Gender'),
                'dateofBirth' => $this->input->post('record_Birthday'),
                'age' => $this->input->post('record_age'),
                'categoryId' => $this->input->post('record_Category'),
                'createdBy' => $this->session->userdata('username'),
                'updateDate' => date('Y-m-d H:i:s')
            );


            $this->DataModel->insertNewPersonRecord($postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/ActiveUsers'));
        }
    }

    function ctl_EditUserRecordDetails(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edit_studentID','Mobile No.' ,'required');
                if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $id= $this->input->post('edit_studentID');
            $postData = array(
                'userGivenId' => $this->input->post('edit_existingUserID'),
                'familyname' => $this->input->post('edit_lastName'),
                'givenname' => $this->input->post('edit_givenName'),
                'middlename' => $this->input->post('edit_middleName'),
                'suffix' => $this->input->post('edit_suffix'),
                'civilStatus' => $this->input->post('edit_CivilStatus'),
                'gender' => $this->input->post('edit_Gender'),
                'dateofBirth' => $this->input->post('edit_Birthday'),
                'age' => $this->input->post('edit_age'),
                'categoryId' => $this->input->post('edit_Category'),
                'createdBy' => $this->session->userdata('username'),
                'updateDate' => date('Y-m-d H:i:s')
            );
            $this->DataModel->mdl_EditUserRecordDetails($id,$postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/ActiveUsers'));
        }
    }


    function ctl_EditCardAssignmentDetail(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edit_userId','Mobile No.' ,'required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
                $id= $this->input->post('edit_userId');
                $card_id = $this->input->post('edit_userCardId');
                $status = $this->input->post('edit_cardStatus');
                $dates = date('Y-m-d H:i:s');

            $this->DataModel->mdl_EditCardAssignmentDetail($id,$card_id,$status,$dates);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/cardList'));
        }
    }




    function ctl_EditMsgTemplateDetails(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('msgId','Mobile No.' ,'required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $id= $this->input->post('msgId');
            $type= $this->input->post('msgType');
            $txt = $this->input->post('msgTxt');
            $updateby = $this->session->userdata('username');
            $dates = date('Y-m-d H:i:s');


            $this->DataModel->mdl_EditMsgTemplateDetail($id,$type,$txt,$updateby,$dates);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/msgTemplates'));
        }
    }



    function ctl_DeleteMsgTemplateDetails(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dlt_msgId','Mobile No.' ,'required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $id= $this->input->post('dlt_msgId');
            $this->DataModel->mdl_DeleteMsgTemplateDetail($id);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/msgTemplates'));
        }
    }




    function test(){

        print_r($_POST);

    }


    function ctl_AddPersonEmergencyContact(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('post_userContactid','Mobile No.' ,'required');
        $this->form_validation->set_rules('post_ContactName', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $postData = array(
                'contactName' => $this->input->post('post_ContactName'),
                'contactRelationship' => $this->input->post('post_Relation'),
                'contactNumber' => $this->input->post('post_Number'),
                'createDate' => date('Y-m-d H:i:s'),
                'createdBy' => $this->session->userdata('username'),
                'updateDate' => date('Y-m-d H:i:s'),
                'personDetailId' => $this->input->post('post_userContactid')
            );
            $this->DataModel->mdl_AddPersonEmergencyContact($postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/ActiveUsers'));
        }
    }

    public function ctl_getUserImageTimelineList(){

        $x = $this->DataModel->mdl_getUserImageTimeline();
        $data = array();

        foreach($x->result() as $r) {

            $data['url'] = array(
                $r->url
            );
        }


        echo json_encode($data);
    }

    function ctl_EditPersonEmergencyContact(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('edit_userContactid','Mobile No.' ,'required');
        $this->form_validation->set_rules('edit_ContactName', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
                $userid = $this->input->post('edit_userContactid');
                $v1 = $this->input->post('edit_ContactName');
                $v2 =$this->input->post('edit_Relation');
                $v3 =$this->input->post('edit_Number');
                $v4 = date('Y-m-d H:i:s');


            $this->DataModel->mdl_EditPersonEmergencyContact($v1,$v2,$v3,$v4,$userid);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/ActiveUsers'));
        }
    }


    function ctl_EditPersonContact(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('edit_userContactid','Mobile No.' ,'required');
        $this->form_validation->set_rules('edit_ContactName', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $userid = $this->input->post('edit_userContactid');
            $v1 = $this->input->post('edit_ContactName');
            $v2 =$this->input->post('edit_Relation');
            $v3 =$this->input->post('edit_Number');
            $v4 = date('Y-m-d H:i:s');


            $this->DataModel->mdl_EditPersonEmergencyContact($v1,$v2,$v3,$v4,$userid);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';
            redirect(site_url('PageController/guardianList'));
        }
    }




    function ctl_AddGateUserCourse(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('courseType','Mobile No.' ,'required');
        $this->form_validation->set_rules('courseName', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $postData = array(
                'courseName' => $this->input->post('courseType'),
                'courseType' => $this->input->post('courseName'),
                'createdBy' => $this->session->userdata('username'),
                'updateDate' => date('Y-m-d H:i:s')
            );

            $this->DataModel->mdl_AddGateUserCourse($postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';

            redirect(site_url('PageController/sysSettings'));
        }
    }


    function ctl_addMessageTemplate(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('msgType','Mobile No.' ,'required');
        $this->form_validation->set_rules('msgTxt', 'Mobile No.','required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('PageController/ErrorPage'));
        } else {
            $postData = array(
                'message_type' => $this->input->post('msgType'),
                'msg_text' => $this->input->post('msgTxt'),
                'createdBy' => $this->session->userdata('username'),
                'createDate' => date('Y-m-d H:i:s'),
                'updatedBy' => $this->session->userdata('username'),
                'updateDate' => date('Y-m-d H:i:s')
            );

            $this->DataModel->insertMessageTemplate($postData);//Transfering data to Model
            $postData['message'] = 'Data Inserted Successfully';

            redirect(site_url('PageController/msgTemplates'));
        }
    }









    function stdConn_list() {
        $results = $this->DataModel-> get_studentConn_list();
        echo json_encode($results);
    }




    public function getRecentGateTopUp()
    {
        $this->load->helper('url');
        $data2["getGateTopUp"] = $this->DataModel->getGateTopUp();

        $json = json_encode($data2);
        echo $json;
    }

    public function ctl_extractUserIdScan()
    {
        $this->load->helper('url');
        $data["userDataScanned"] = $this->DataModel->mdl_extractUserIdScan();
        $json = json_encode($data);
        echo $json;
    }


    public function CombinedPhotoUpload()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('stdNumb','Mobile No.','required');
        $this->form_validation->set_rules('FilePathName','Mobile No.','required');
        $config['upload_path'] = './ui/photo_library/';
        $config['allowed_types'] = 'jpg|gif|jpeg|png';
        $this->load->library('upload', $config);


        if($this->form_validation->run() == FALSE){
            redirect(site_url('PageController/reporting'));
        }else
        {

            $imagepath = 'ui/photo_library/'.$this->input->post('FilePathName');
            $imgData = array(
                'partyId' => $this->input->post('stdNumb'),
                'image_url' => $imagepath,
                'updateDate' => date('Y-m-d H:i:s')
            );
        }
        $this->DataModel->connection_personImage($imgData);
        $imgData['message'] = 'Data Inserted Successfully';

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('uploadTry', $error);

        } else {
            $file_data = $this->upload->data();
            $data['img'] = base_url() . '/ui/photo_library/' . $file_data['file_name']; redirect(site_url('PageController/admin'));
        }


    }

    public function updateExistingUserPhoto()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('stdNumb','Mobile No.','required');
        $this->form_validation->set_rules('FilePathName','Mobile No.','required');
        $config['upload_path'] = './ui/photo_library/';
        $config['allowed_types'] = 'jpg|gif|jpeg|png';
        $this->load->library('upload', $config);


        if($this->form_validation->run() == FALSE){
            redirect(site_url('PageController/reporting'));
        }else
        {

            $imagepath = 'ui/photo_library/'.$this->input->post('FilePathName');
            $imgData = array(
                'partyId' => $this->input->post('stdNumb'),
                'image_url' => $imagepath,
                'updateDate' => date('Y-m-d H:i:s')
            );
        }
        $this->DataModel->updateUserPhotoFile($imgData);
        $imgData['message'] = 'Data Inserted Successfully';

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('uploadTry', $error);

        } else {
            $file_data = $this->upload->data();
            $data['img'] = base_url() . '/ui/photo_library/' . $file_data['file_name'];
            redirect(site_url('PageController/students'));
        }


    }


    public function uploadNewUserPhotoFile()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('up_stdNumb','Mobile No.','required');
        $this->form_validation->set_rules('FilePathName_upload','Mobile No.','required');
        $config['upload_path'] = './ui/photo_library/';
        $config['allowed_types'] = 'jpg|gif|jpeg|png';
        $this->load->library('upload', $config);


        if($this->form_validation->run() == FALSE){
            redirect(site_url('PageController/reporting'));
        }else
        {

            $imagepath = 'ui/photo_library/'.$this->input->post('FilePathName_upload');
            $imgData = array(
                'partyId' => $this->input->post('up_stdNumb'),
                'image_url' => $imagepath,
                'updateDate' => date('Y-m-d H:i:s')
            );
        }
        $this->DataModel->insertUserPhotoFile($imgData);
        $imgData['message'] = 'Data Inserted Successfully';

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('uploadTry', $error);

        } else {
            $file_data = $this->upload->data();
            $data['img'] = base_url() . '/ui/photo_library/' . $file_data['file_name'];
            redirect(site_url('PageController/students'));
        }


    }

    public function ctl_uploadUserPhoto()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_PartyIdUpload','Mobile No.','required');
        $this->form_validation->set_rules('FilePathName_upload','Mobile No.','required');
        $config['upload_path'] = './ui/photo_library/';
        $config['allowed_types'] = 'jpg|gif|jpeg|png';
        $this->load->library('upload', $config);


        if($this->form_validation->run() == FALSE){
            redirect(site_url('PageController/ErrorPage'));
        }else
        {

            $imagepath = 'ui/photo_library/'.$this->input->post('FilePathName_upload');
            $imgData = array(
                'personDetailId' => $this->input->post('post_PartyIdUpload'),
                'image_url' => $imagepath,
                'createdBy' => $this->session->userdata('username'),
                'createDate' => date('Y-m-d H:i:s'),
                'updateDate' => date('Y-m-d H:i:s')
            );
        }
        $this->DataModel->mdl_uploadUserPhoto($imgData);
        $imgData['message'] = 'Data Inserted Successfully';

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('uploadTry', $error);

        } else {
            $file_data = $this->upload->data();
            $data['img'] = base_url() . '/ui/photo_library/' . $file_data['file_name'];
            redirect(site_url('PageController/ActiveUsers'));
        }


    }


    public function ctl_updateExistingUserPhoto()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_PartyIdPhotoEdit','Mobile No.','required');
        $this->form_validation->set_rules('FilePathName_edit','Mobile No.','required');
        $config['upload_path'] = './ui/photo_library/';
        $config['allowed_types'] = 'jpg|gif|jpeg|png';
        $this->load->library('upload', $config);


        if($this->form_validation->run() == FALSE){
            redirect(site_url('PageController/ErrorPage'));
        }else
        {

            $imagepath = 'ui/photo_library/'.$this->input->post('FilePathName_edit');
            $imgData = array(
                'personDetailId' => $this->input->post('post_PartyIdPhotoEdit'),
                'image_url' => $imagepath,
                'createdBy' => $this->session->userdata('username'),
                'createDate' => date('Y-m-d H:i:s'),
                'updateDate' => date('Y-m-d H:i:s')
            );
        }
        $this->DataModel->mdl_updateUserPhoto($imgData);
        $imgData['message'] = 'Data Inserted Successfully';

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('uploadTry', $error);

        } else {
            $file_data = $this->upload->data();
            $data['img'] = base_url() . '/ui/photo_library/' . $file_data['file_name'];
            redirect(site_url('PageController/ActiveUsers'));
        }


    }

public function ctl_buildSmsNotification(){
    $cardId =$this->input->post('crdScanned');
    //$cardId = '2345243523';
    $data = $this->DataModel->mdl_getGuardianNumber($cardId);
    $data2 = $this->DataModel->mdl_studentFamilyname($cardId);
    $data3 = $this->DataModel->mdl_studentGivenname($cardId);
    $status =  $this->DataModel->mdl_checkPersonCampusStatus($cardId);
    $json_data = json_decode(json_encode($data),true);
    $json_data2 = json_decode(json_encode($data2),true);
    $json_data3 = json_decode(json_encode($data3),true);
    $json_status =  json_decode(json_encode($status),true);
    $num = $json_data[0]['contactNumber'];
    $fname = $json_data2[0]['familyname'];
    $gname = $json_data3[0]['givenname'];
    $ustat = $json_status[0]['campus_status'];


    if($ustat == 0)
    {
        $this->DataModel->mdl_updatePersonCampusStatusIn($cardId);
        $con_msg = $fname ." , ".$gname ." ". 'has walked in to the campus premises. This is a system generated message.';
        //echo $con_msg;

        //Phone SMS Code
        /*        $url = 'http://192.168.1.4:8080'; //Change Url If Needed
                $ch = curl_init($url);
                $jsonData = array(
                    'number' => $num,
                    'text' => $con_msg
                );
                $jsonDataEncoded = json_encode($jsonData);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                $output = curl_exec($ch);*/
        // end
        //Semaphore
         /*  $ch = curl_init();
            $parameters = array(
                'apikey' => '24da6cd44efc8df71385f0c1308b6548', //Your API KEY
                'number' => $num,
                'message' => $con_msg,
               'sendername' => '');
            curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $output = curl_exec( $ch );
            curl_close ($ch);*/

        $post_smsPush = array(
            'sms_to' => $num,
            'message'=>$con_msg,
            'sms_status'=>'Pending',
            'createdon' =>date('Y-m-d H:i:s'),
            'updatedon' =>date('Y-m-d H:i:s')
        );


        $this->DataModel->mdl_addPendingSms($post_smsPush);

       // return $output;
    }
    elseif($ustat == 1){
        $this->DataModel->mdl_updatePersonCampusStatusOut($cardId);
        $con_msg = $fname ." , ".$gname ." ". 'has walked out to the campus premises. This is a system generated message.';
       // echo $con_msg;

        //Phone SMS Code
      /*  $url = 'http://192.168.1.4:8080'; //Change Url If Needed
        $ch = curl_init($url);
        $jsonData = array(
            'number' => $num,
            'text' => $con_msg
        );
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $output = curl_exec($ch);*/
// end
        //Semaphore
          /* $ch = curl_init();
    $parameters = array(
        'apikey' => '24da6cd44efc8df71385f0c1308b6548', //Your API KEY
        'number' => $num,
        'message' => $con_msg,
       'sendername' => '');
    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);*/

        $post_smsPush = array(
            'sms_to' => $num,
            'message'=>$con_msg,
            'sms_status'=>'Pending',
            'createdon' =>date('Y-m-d H:i:s'),
            'updatedon' =>date('Y-m-d H:i:s')
        );


        $this->DataModel->mdl_addPendingSms($post_smsPush);
       // return $output;
    }

  //Phone SMS Code
//   $url = 'http://192.168.1.4:8080'; //Change Url If Needed
//    $ch = curl_init($url);
//    $jsonData = array(
//        'number' => $num,
//        'text' => $con_msg
//    );
//    $jsonDataEncoded = json_encode($jsonData);
//    curl_setopt($ch, CURLOPT_POST, 1);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//   $output = curl_exec($ch);
// end
    //Semaphore
/*   $ch = curl_init();
    $parameters = array(
        'apikey' => '24da6cd44efc8df71385f0c1308b6548', //Your API KEY
        'number' => $num,
        'message' => $con_msg,
       'sendername' => '');
    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);*/
    return $output;
    //end
    //return 'SMS Sent';

    }


    public function checkCardDetails(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('crdScanned','Mobile No.','required');
        $this->form_validation->set_rules('gateStationId','Mobile No.','required');
        if($this->form_validation->run() == FALSE){
            redirect(site_url('PageController/ErrorPage'));
        }
        else
        {
            $cardId =$this->input->post('crdScanned');
            $stationId = $this->input->post('gateStationId');

            $post_cardData = array(
            'card_id' => $cardId,
            'createDate' =>date('Y-m-d H:i:s'),
            'gate_id'=>$stationId
            );
           $this->DataModel->insertCardHistoryDetails($post_cardData);

        }
    }




}




?>