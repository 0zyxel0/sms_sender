<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MsgController extends CI_Controller
{


    function __construct() {
        parent::__construct();
        $this->load->model('DataModel');
    }
//    public function gw_send_sms() {
//        $send_sms_mobile_no = $this->input->post("mobileno");
//        $send_sms_message = trim($this->input->post("message"));
//        foreach (explode(",", $send_sms_mobile_no) as $mobile_no) {
//            FIXME : Enhance design so that user will know if message is successfully sent or failed
//            $result = $this->send_sms(trim($mobile_no), $send_sms_message);
//            log_message("INFO", implode("; ", [trim($mobile_no), $result]));
//        }
//
//        redirect(site_url('PageController/broadcast'));
//    }
//
//    private function send_sms($send_sms_mobile_no, $send_sms_message) {
//        $sendsms_username = "API5UFGHP814P";
//        $sendsms_password = "API5UFGHP814PXQQTH";
//        $sendsms_senderid = "VADER";
//
//        $query_string = "api.aspx?apiusername=" . $sendsms_username . "&apipassword=" . $sendsms_password;
//        $query_string .= "&senderid=" . rawurlencode($sendsms_senderid) . "&mobileno=" . rawurlencode($send_sms_mobile_no);
//        $query_string .= "&message=" . rawurlencode(stripslashes($send_sms_message)) . "&languagetype=1";
//        $url = "http://gateway.onewaysms.ph:10001/" . $query_string;
//        $fd = @implode('', file($url));
//
//        if ($fd) return $fd > 0 ? "success" : "Please refer to API on Error : " . $fd;
//
//        return "no contact with gateway";
//    }
//}


function test(){
    print_r($_POST);


    $message= $this->input->post('message');
    $name = $this->input->post('StudentNames');
    $finalmsg = $name . " " . $message;
    echo $finalmsg;
}

/*function send_SingleSms(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('NumberTo','Mobile No.','required');
    if($this->form_validation->run() == FALSE){
        redirect(site_url('PageController/ErrorPage'));
    }
    else
    {

        $NumberTo = $this->input->post('NumberTo');
        $message= $this->input->post('message');
        $name = $this->input->post('StudentNames');
        $con_msg = $name ." ". $message;
        $this->DataModel->SendSMS($NumberTo,$con_msg);
        log_message("INFO", implode("; ", [trim($NumberTo), $con_msg]));
        redirect(site_url('PageController/reporting_late'));
    }
}*/


    function send_NotificationToGuardian($NumberTo, $msg){

       $url = 'http://192.168.1.4:8080';
       $ch = curl_init($url);
        $jsonData = array(
            'number' => $NumberTo,
            'text' => $msg
        );
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);
    }




function send_SingleSms_Phone(){

    $NumberTo = $this->input->post('NumberTo');
    $message= $this->input->post('message');
    $name = $this->input->post('StudentNames');
    $con_msg = $name ." ". $message;

    //API Url
    $url = 'http://192.168.1.4:8080';

//Initiate cURL.
    $ch = curl_init($url);

//The JSON data.
    $jsonData = array(
        'number' => $NumberTo,
        'text' => $message
    );

//Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
   curl_exec($ch);
   
}
function send_SingleSms_Semaphore(){


        $NumberTo = $this->input->post('NumberTo');
        $message= $this->input->post('message');
        $name = $this->input->post('StudentNames');
        $con_msg = $name ." ". $message;
        log_message("INFO", implode("; ", [trim($NumberTo), $con_msg]));
        $ch = curl_init();
        $parameters = array(
            'apikey' => '24da6cd44efc8df71385f0c1308b6548', //Your API KEY
            'number' => $NumberTo,
            'message' => $message,
            'sendername' => ''
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

//Show the server response
        echo



        $output;


}

function send_bulkSms(){
    $NumberTo = $this->input->post('NumberTo');
    $message= $this->input->post('message');
    $name = $this->input->post('StudentNames');
    $con_msg = $name ." ". $message;
    log_message("INFO", implode("; ", [trim($NumberTo), $con_msg]));
    $ch = curl_init();
    $parameters = array(
        'apikey' => '24da6cd44efc8df71385f0c1308b6548', //Your API KEY
        'number' => '',
        'message' => $message,
        'sendername' => ''
    );
    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
    curl_setopt( $ch, CURLOPT_POST, 1 );

//Send the parameters set above with the request
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// Receive response from server
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);

//Show the server response
    echo $output;
}

}
?>