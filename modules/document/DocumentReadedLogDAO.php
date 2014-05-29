<?php
/*
 @class DocumentReadedLog

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class DocumentReadedLogDAO {
	//document_orl, member_orl, reg_datetime, ipaddress
	
	public function isUserReaded($document_orl, $member_orl) {
    $__Db = Db::getInstance();
		// 총수
		$__Db->query = "SELECT IFNULL( COUNT(member_orl) , 0) AS count FROM document_readed_log ";
    $__Db->query .= "WHERE document_orl = {$document_orl} AND member_orl = {$member_orl} ";
		$rs = $__Db->object();
    return ($rs['count'] > 0);
	}

	public function insert($args) {
    $__Db = Db::getInstance();
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$reg_datetime = _date();
		
		$__Db->query = "INSERT INTO document_readed_log ( document_orl, member_orl, module_orl, reg_datetime, ipaddress ) values (
		  {$args->document_orl}
		  , {$args->member_orl}
		  , {$args->module_orl}
		  , '{$reg_datetime}'
		  , '{$ipaddress}'
		)";
    
    $__Db->insert();
	}

  function del($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "DELETE FROM document_readed_log WHERE document_orl = {$document_orl} ";
		$__Db->del();
	}

}

?>
