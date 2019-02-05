<?php
/**
 * Created by PhpStorm.
 * User: Pharrie
 * Date: 01/02/2019
 * Time: 22:50
 */

class SmsController extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('Sms_Model');
    }

    public function ctl_generateSmsTrigger(){
        $results = $this->Sms_Model-> mdl_getPendingMessage();
        $json_results = json_encode($results);
        echo $json_results;
    }

    public function ctl_countPendingSms(){
        $results = $this->Sms_Model-> mdl_countPendingMessage();
        $json_results = json_decode(json_encode($results),true);
        $count = $json_results[0]['messages'];
        echo $count;

    }

    public function ctl_getCurrentIpAddress(){
        $ipGet = $this->Sms_Model->mdl_getIpAddress();
        $json_ipGet = json_decode(json_encode($ipGet),true);
        $extractedIp = $json_ipGet[0]['ipaddress'];
       echo $extractedIp;
    }

    public function ctl_saveIpAddress(){
        $data = array(
            'ipaddress' => $this->input->post('smsIpAddress'),
        );

        $this->Sms_Model->mdl_saveIpAddress($data);


        redirect(site_url('PageController/sysSettings'));

    }

    public function ctl_updatePendingSmsStatus(){

        $pendingSms = $this->Sms_Model-> mdl_getPendingMessage();
        if ($pendingSms != null){
            $json_pending = json_decode(json_encode($pendingSms),true);
            $id = $json_pending[0]['id'];
            $sms_to = $json_pending[0]['sms_to'];
            $message = $json_pending[0]['message'];
            // echo $id;
            // echo $sms_to;
            // echo $message;



            // $postDataId = array('id' => $id,);
           // $this->Sms_Model->mdl_updateMessageStatus($id);


            //Semaphore
          /*  $ch = curl_init();
            $parameters = array(
                'apikey' => '24da6cd44efc8df71385f0c1308b6548', //Your API KEY
                'number' => $sms_to,
                'message' => $message,
                'sendername' => '');
            curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $output = curl_exec( $ch );
            curl_close ($ch);*/
            //Semaphore End

            //Phone SMS Code
            $ipaddress = $this->Sms_Model-> mdl_getIpAddress();
              $json_ipaddress = json_decode(json_encode($ipaddress),true);
              $decoded_ip = $json_ipaddress[0]['ipaddress'];
               $url = $decoded_ip; //Change Url If Needed
               $ch = curl_init($url);
                $jsonData = array(
                    'number' => $sms_to,
                    'text' => $message
                );
                $jsonDataEncoded = json_encode($jsonData);
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
              $output = curl_exec($ch);

            $this->Sms_Model->mdl_updateMessageStatus($id);

            // Phone End




           // return $output;
        }else{
            return 'No Pending Messages';
        }
    }


}