<?php
/**
 * Created by PhpStorm.
 * User: Pharrie
 * Date: 01/02/2019
 * Time: 21:50
 */


class Sms_Model extends CI_Model{


    function mdl_getPendingMessage(){
        $query = $this->db->query("SELECT id,sms_to, message 
                                    FROM bulknotification_activities
                                    WHERE sms_status = 'Pending' 
                                    LIMIT 1
                                  ");
        return $query->result();
    }



    function mdl_updateMessageStatus($postDataId){

        $query = $this->db->query("UPDATE bulknotification_activities
                                   SET sms_status = 'Sent'
                                   WHERE id = '$postDataId'
                                  ");

        // mysqli_query($query);
    }

    function mdl_saveIpAddress($postData){

        $this->db->where('id', 1);
        $q = $this->db->get('sms_settings');
        $this->db->reset_query();

        if ( $q->num_rows() > 0 )
        {
            $this->db->where('id', 1)->update('sms_settings', $postData);
        } else {
            $this->db->set('id', 1)->insert('sms_settings', $postData);
        }
    }

    function mdl_getIpAddress(){
        $query = $this->db->query(" SELECT ipaddress
                                     FROM sms_settings
                                     WHERE id = 1
                                  ");
        return $query->result();
    }



    function mdl_countPendingMessage(){
        $query = $this->db->query(" SELECT COUNT(sms_to) as messages 
                                     FROM bulknotification_activities
                                     WHERE sms_status = 'Pending'
                                  ");
        return $query->result();

    }

}