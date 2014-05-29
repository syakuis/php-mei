<?php
/*
 @class CommentVotedLog

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class CommentVotedLogDAO {
	//comment_orl, member_orl, module_orl, target_orl, vote, reg_datetime, ipaddress

	function isUserVoted($comment_orl, $member_orl) {
    $__Db = Db::getInstance();
	// 총수
	$__Db->query = "SELECT IFNULL( COUNT(member_orl) , 0) AS count FROM comment_voted_log ";
    $__Db->query .= "WHERE comment_orl = {$comment_orl} AND member_orl = {$member_orl} ";
	$rs = $__Db->object();
    return ($rs['count'] > 0);
	}

	function insert($args) {
    $__Db = Db::getInstance();
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$reg_datetime = _date();
		
		$__Db->query = "INSERT INTO comment_voted_log ( comment_orl, member_orl, module_orl, target_orl, vote, reg_datetime, ipaddress ) values (
		  {$args->comment_orl}
		  , {$args->member_orl}
		  , {$args->module_orl}
		  , {$args->target_orl}
		  , {$args->vote}
		  , '{$reg_datetime}'
		  , '{$ipaddress}'
		)";
    
    $__Db->insert();
	}

  function deleteOne($comment_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "DELETE FROM comment_voted_log WHERE comment_orl = {$comment_orl} ";
		$__Db->del();
	}

	function deleteTargetOrl($module_orl, $target_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "DELETE FROM comment_voted_log WHERE module_orl = {$module_orl} AND target_orl = {$target_orl} ";
		$__Db->del();
	}

}

?>
