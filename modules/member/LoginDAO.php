<?php
/*
 @class Login

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class LoginDAO {
	//login_orl, member_orl, sid, ipaddress, user_agent, reg_datetime
	
	function insert($member_orl) {
    $__Db = Db::getInstance();

		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$reg_datetime = _date();
    $sid = session_id();
		
		$__Db->query = "INSERT INTO login ( member_orl, sid, ipaddress, user_agent, reg_datetime ) values (
		    {$member_orl}
		  , '{$sid}'
		  , '{$ipaddress}'
		  , '{$user_agent}'
		  , '{$reg_datetime}'
		)";

    $login_orl = $__Db->insert();
    return $login_orl;
	}

}
?>
