<?php
function gw_send_sms($user,$pass,$sms_from,$sms_to,$sms_msg)  
{           
			$query_string = "api.aspx?apiusername=".$user."&apipassword=".$pass;
			$query_string .= "&senderid=".rawurlencode($sms_from)."&mobileno=".rawurlencode($sms_to);
			$query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";        
			$url = "http://gateway.onewaysms.ph:10001/".$query_string; 
			$fd = @implode ('', file ($url));      
			if ($fd)  
			{                       
		if ($fd > 0) {
		Print("MT ID : " . $fd);
		$ok = "success";
		}        
		else {
		print("Please refer to API on Error : " . $fd);
		$ok = "fail";
		}
			}           
			else      
			{                       
						// no contact with gateway                      
						$ok = "fail";       
			}           
			return $ok;  
}  

//Print("Sending to one way sms " . gw_send_sms($_POST["username"], $_POST["password"], $_POST["senderid"], $_POST["mobileno"], $_POST["message"]));
header("Location: http://gateway.onewaysms.ph:10001/api.aspx?apiusername=".$_POST["username"]."&apipassword=".$_POST["password"]."&senderid=".$_POST["senderid"]."&mobileno=".$_POST["mobileno"]."&message=".$_POST["message"]."&languagetype=1");
exit();
?>