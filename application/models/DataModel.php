<?php
class DataModel extends CI_Model{
    function __construct() {
        parent::__construct();
    }



    function saveAssignNumber($data){
// Inserting in Table(students) of Database(college)
// Woods Module for connection of ID to student or staff
        $this->db->insert('party_stdconnector', $data);
    }


    function mdl_getGateUsersForAssignment(){
        $query = $this->db->query("call fn_GetExistingCardUsers()");
        $query->row();
        return $query;
    }


    function mdl_GetAllUserCategory(){
        $query = $this->db->query("call fn_GetAllUserCategory()");
        $query->row();
        return $query;

    }


    function mdl_MsgTemplateList(){
        $query = $this->db->query("call fn_MsgTemplates()");
        $query->row();
        return $query;

    }


    function mdl_GetGateHistoryTimeline(){
        $query = $this->db->query("call fn_GateHistoryReport()");
        $query->row();
        return $query;

    }


    function mdl_getUserImageTimeline(){
        $query = $this->db->query("call fn_ImageGateHistory()");
        $query->row();
        return $query;

    }






    function mdl_GetGuardianList(){
        $query = $this->db->query("call fn_getGuardianList()");
        $query->row();
        return $query;

    }



    function  assignCardToUser($postData){
        $this->db->set('assignmentId', 'UUID()', FALSE);
        $this->db->insert('gate_cardassignment',$postData);
    }


    function connection_personImage($imgData){
        $this->db->insert('person_image',$imgData);
    }

    function insertUserPhotoFile($imgData){
        $this->db->insert('person_image',$imgData);
    }

    function mdl_uploadUserPhoto($postData){
        $this->db->set('photoId', 'UUID()', FALSE);
        $this->db->insert('gate_personphoto',$postData);
    }

    function mdl_updateUserPhoto($imgData){
        extract($imgData);
        $path =$imgData['image_url'];
        $record = $imgData['personDetailId'];
        $date = $imgData['updateDate'];
        $query = $this->db->query("UPDATE gate_personphoto
                                   SET image_url = '$path',updateDate = '$date'
                                   WHERE personDetailId = '$record'
                                  ");
        mysqli_query($query);
    }

      function test($postData){
        extract($postData);
       print_r($postData);
    }

    function mdl_EditUserRecordDetails($id,$postData){
        $this->db->where('personDetailId', $id);
        $this->db->update('gate_persondetails', $postData);
    }


    function mdl_editGateUserCategory($Id, $v1,$v2,$v3,$v4, $update){
        $query = $this->db->query("UPDATE gate_categorytype
                                   SET categoryName = '$v1',categoryType = '$v2' ,gateTimeInSetting = '$v3', gateTimeSettingAbsent = '$v4',updateDate ='$update'
                                   WHERE categoryId = '$Id'
                                  ");
        mysqli_query($query);
    }



    function mdl_EditCardAssignmentDetail($id,$card_id,$status,$dates){
        $query = $this->db->query("UPDATE gate_cardassignment
                                   SET card_id = '$card_id',isDisabled = '$status', updateDate = '$dates'
                                   WHERE partyId = '$id'
                                  ");
        mysqli_query($query);
    }


    function mdl_EditMsgTemplateDetail($id,$type,$txt,$updateby,$dates){
        $query = $this->db->query("UPDATE msg_template
                                   SET message_type = '$type',msg_text = '$txt',updatedBy = '$updateby', updateDate = '$dates'
                                   WHERE messageId = '$id'
                                  ");
        mysqli_query($query);
    }


    function mdl_DeleteMsgTemplateDetail($id){
        $query = $this->db->query("DELETE FROM msg_template                                   
                                   WHERE messageId = '$id'
                                  ");
        mysqli_query($query);
    }



    function mdl_deleteGateUserCategory($id){
        $query = $this->db->query(" DELETE FROM gate_categorytype
                                    WHERE categoryId = '$id'
                                  ");
        mysqli_query($query);
    }




    function insertNewPersonRecord($postData){
        $this->db->set('personDetailId', 'UUID()', FALSE);
        $this->db->insert('gate_persondetails',$postData);
    }

    function insertNewUserCategory($postData){
        $this->db->set('categoryId', 'UUID()',FALSE);
        $this->db->insert('gate_categorytype',$postData);
    }


    function insertMessageTemplate($postData){
        $this->db->set('messageId', 'UUID()',FALSE);
        $this->db->insert('msg_template',$postData);
    }




    function mdl_AddGateUserCourse($postData)
    {
        $this->db->set('courseId', 'UUID()', FALSE);
        $this->db->insert('gate_coursetype', $postData);
    }


    function getAllGateUsers(){
        $query = $this->db->query("call fn_GenerateAllUsers()");
        $query->row();
        return $query;
    }



    function mdl_GetMsgTemplateList(){
        $query = $this->db->query("select
                                    messageId AS 'Id',
                                    message_type AS 'Type',
                                    msg_text AS 'Text',
                                    updatedBy As 'By',
                                    updateDate as 'date'
                                    from msg_template");
        $query->row();
        return $query;
    }

    function updateUserPhotoFile($imgData){
        extract($imgData);
        $path =$imgData['image_url'];
        $record = $imgData['partyId'];
        $date = $imgData['updateDate'];
        $query = $this->db->query("UPDATE person_image 
                                   SET image_url = '$path',updateDate = '$date'
                                   WHERE partyId = '$record'
                                  ");
        mysqli_query($query);
    }







    function getAllCategory(){
        $query = $this->db->query("Select categoryId,categoryName 
                                   FROM gate_categorytype");
        return $query->result();
    }

    function getAllMsgType(){
        $query = $this->db->query("Select message_type,msg_text 
                                   FROM msg_template");
        return $query->result();
    }



    function getGateTopUp()
    {
        $query = $this->db->query("call fn_GateScanTopUp()");
        $query->row();
        return $query;
    }


    function mdl_extractUserIdScan(){
        $query = $this->db->query("call fn_GateScanningExtract()");
        $query->row();
        return $query;
    }



    public function getGateHistoryReport()
    {
        $query = $this->db->query("call fn_GateHistoryReport()");
        $query->row();
        return $query;
    }


    public function checkUserIdExist($data){
        $query = $this->db->query('select userGivenId
                                    from gate_persondetails
                                    where userGivenId = ' +"$data"
                                    );
        $query->row();
        return $query;
    }






    public function getStudentListReport(){
        $query = $this->db->query("call fn_GenerateStudentListReport()");
        $query->row();
        return $query;
    }

    public function getStaffListReport(){
        $query = $this->db->query('SELECT accountID, lastname, firstname, recordstatus FROM staff');
        $query->row();
        return $query;
    }

    public function mdl_gateHistoryTimeline(){
        $query = $this->db->query("call fn_GateHistoryTimeline()");
        $query->row();
        return $query;
    }


    public function mdl_gateHistoryLateTimeline(){
        $query = $this->db->query("call fn_GateHistoryLateTimeline()");
        $query->row();
        return $query;
    }


    public function mdl_GateHistoryEarlyTimeline(){
        $query = $this->db->query("call fn_GateHistoryEarlyTimeline()");
        $query->row();
        return $query;
    }

    public function mdl_ReportAbsentUserDataTable(){
        $query = $this->db->query("call fn_GateHistoryAbsentTimeline()");
        $query->row();
        return $query;
    }


    function userId_exists($key)
    {

        $this->db->where('usergivenId', $key);
        $query = $this->db->get("gate_persondetails");
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }



    public function getLateUserList(){
        $query = $this->db->query('select distinct gh.createDate,ps.card_id,p.lastName, p.firstName,gh.gate_id
                                    from gate_history gh
                                    join party_stdconnector ps on ps.card_id = gh.card_id
                                    join gate_usercategory gc on ps.userCatId = gc.userCatId
                                    join student s on ps.partyid = s.studentNumber
                                    join person p on p.personID = s.personID
                                    where CAST(gh.createdate as time) >= gc.userTimeSetting
                                    ');
        $query->row();
        return $query;

    }


    public function getOnTimeUserList(){
        $query = $this->db->query('select distinct gh.createDate,ps.card_id,p.lastName, p.firstName,gh.gate_id
                                    from gate_history gh
                                    join party_stdconnector ps on ps.card_id = gh.card_id
                                    join gate_usercategory gc on ps.userCatId = gc.userCatId
                                    join student s on ps.partyid = s.studentNumber
                                    join person p on p.personID = s.personID
                                    where CAST(gh.createdate as time) <= gc.userTimeSetting
                                    ');
        $query->row();
        return $query;

    }


    public function insertCardHistoryDetails($post_cardData){
        $this->db->insert('gate_history',$post_cardData);
    }

    public function mdl_AddPersonEmergencyContact($postData){
        $this->db->set('contactId', 'UUID()',FALSE);
        $this->db->insert('user_emergencycontact',$postData);
    }

    public function mdl_getMessageTemplate($temptype){
        $query = $this->db->query("select msg_text
                                   from msg_template
                                   where message_type = .'$temptype'.
                                   LIMIT 1
                                    ");
        $query->row();
        return $query;
    }

    public function mdl_checkPersonCampusStatus($postData){
        $query = $this->db->query("select campus_status
                                   from gate_personstatus
                                   where card_id = '$postData'
                                 
                                    ");
        return  $query->result();
    }
// Going In the Gate
    public function mdl_updatePersonCampusStatusIn($cardId){

        $query = $this->db->query("UPDATE gate_personstatus
                                   SET campus_status = 1
                                   WHERE card_id = '$cardId'
                                  ");
        //mysqli_query($query);
    }
// Going Out the Gate
    public function mdl_updatePersonCampusStatusOut($cardId){

        $query = $this->db->query("UPDATE gate_personstatus
                                   SET campus_status = 0
                                   WHERE card_id = '$cardId'
                                  ");
      //  mysqli_query($query);
    }


    public function mdl_addPendingSms($data){
        $this->db->insert('bulknotification_activities', $data);
    }



    public function mdl_AddGatePersonStatus($postData){
        $this->db->insert('gate_personstatus',$postData);
    }
    public function mdl_CheckGatePersonStatus($cardId, $date){
        $query = $this->db->query('select distinct gh.createDate,ps.card_id,p.lastName, p.firstName,gh.gate_id
                                    from gate_history gh
                                    join party_stdconnector ps on ps.card_id = gh.card_id
                                    join gate_usercategory gc on ps.userCatId = gc.userCatId
                                    join student s on ps.partyid = s.studentNumber
                                    join person p on p.personID = s.personID
                                    where CAST(gh.createdate as time) <= gc.userTimeSetting
                                    ');
        $query->row();
        return $query;
    }


    public function mdl_EditPersonEmergencyContact($v1,$v2,$v3,$v4,$userid){


        $query = $this->db->query("UPDATE user_emergencycontact
                                   SET contactName = '$v1',contactRelationship = '$v2' ,contactNumber = '$v3', updateDate = '$v4'
                                   WHERE personDetailId = '$userid'
                                  ");
        mysqli_query($query);
    }


    public function mdl_getGuardianNumber($cardId){
        $query = $this->db->query("SELECT ec.contactNumber
                                   FROM gate_cardassignment ca
                                   LEFT JOIN gate_persondetails pd on pd.personDetailId = ca.partyid
                                   LEFT JOIN user_emergencycontact ec on ec.personDetailId = pd.personDetailId
                                   WHERE ca.card_id = '$cardId'
                                  ");
        return  $query->result();

    }

    public function mdl_studentFamilyname($cardId){
        $query = $this->db->query("SELECT pd.familyname
                                   FROM gate_cardassignment ca
                                   LEFT JOIN gate_persondetails pd on pd.personDetailId = ca.partyid
                                   WHERE ca.card_id = '$cardId'
                                  ");
        return  $query->result();

    }
    public function mdl_studentGivenname($cardId){
        $query = $this->db->query("SELECT pd.givenname 
                                   FROM gate_cardassignment ca
                                   LEFT JOIN gate_persondetails pd on pd.personDetailId = ca.partyid
                                   WHERE ca.card_id = '$cardId'
                                  ");
        return  $query->result();

    }


    //not used scripts
    //
    //
    //
    //
    //
    //

    public function getStudentAbsentList()
    {
        $query = $this->db->query("call fn_StudentAbsentList()");
        $query->row();
        return $query;
    }



    function getTopScan()
    {
        $query = $this->db->query('SELECT *
                                   FROM gate_history gh
                                   JOIN party_stdconnector ps on ps.card_id = gh.card_id
                                   JOIN person_image pi on pi.partyId = ps.partyId
                                   ORDER BY gh.transaction_id DESC
                                   LIMIT 1');
        $query->result_array();
        return $query;

    }

    function SendSMS($NumberTo,$message){
        $apiCode = "TR-MIGUE700379_LDSAH";
        $api_url = 'https://www.itexmo.com/php_api/api.php';
        $msgData = array('1' => $NumberTo, '2' => $message, '3' => $apiCode);
        $param = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($msgData)
            )
        );
        $context  = stream_context_create($param);
        $response = file_get_contents($api_url, null, $context);
        return $response;
    }






}
?>