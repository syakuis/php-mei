<?php
/*
 @class Comment

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class CommentDAO {
	//comment_orl, module_orl, target_orl, parent_orl, reply_group, reply_depth, reply_seq, member_orl, user_id, nickname, content, content_text, good_count, bad_count, accuse_count, is_mobile, state, ipaddress, reg_datetime, update_datetime, listorder

  function getCount($args) {
    $__Db = Db::getInstance();
		// 총수
		$__Db->query = "SELECT IFNULL( COUNT(comment_orl) , 0) AS count FROM comment ";
		$__Db->query .= " WHERE module_orl = {$args->module_orl} AND target_orl = {$args->target_orl} ";
		$rs = $__Db->object();
		return $rs['count'];
	}
	
	function select($args, $start_idx = NULL,$page_row = NULL) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM comment ";
		$__Db->query .= " WHERE module_orl = {$args->module_orl} AND target_orl = {$args->target_orl} ";
    $__Db->query .= " ORDER BY listorder, reply_seq ";
    if ( !is_null($start_idx) && !is_null($page_row) ) $__Db->query .= " LIMIT {$start_idx},{$page_row} ";
		return $__Db->select();
	}
	
	function selectOne($comment_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM comment WHERE comment_orl = {$comment_orl} LIMIT 1";
		return $__Db->object();
	}

  function selectPortlet($limit = 10) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM comment ";
    $__Db->query .= " ORDER BY listorder, reply_seq LIMIT {$limit} ";
		return $__Db->select();
  }
	
	function insert($args) {
    $__Db = Db::getInstance();
		$member_orl = $_SESSION['_SESS_MEMBER_ORL'];
		$user_id = $_SESSION['_SESS_USER_ID'];
		$nickname = $_SESSION['_SESS_NICKNAME'];
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$reg_datetime = _date();
    
		$__Db->query = "INSERT INTO comment ( module_orl, target_orl, parent_orl, reply_group, reply_depth, reply_seq, member_orl, user_id, nickname, content, content_text, is_mobile, ipaddress, reg_datetime ) values (
		   {$args['module_orl']}
		  , {$args['target_orl']}
		  , {$args['parent_orl']}
		  , {$args['reply_group']}
		  , {$args['reply_depth']}
		  , {$args['reply_seq']}
		  , {$member_orl}
		  , '{$user_id}'
		  , '{$nickname}'
		  , '{$args['content']}'
		  , '{$args['content_text']}'
		  , '{$args['is_mobile']}'
		  , '{$ipaddress}'
		  , '{$reg_datetime}'
		)";
    
    $comment_orl = $__Db->insert();
		self::updateListorder($comment_orl,$args['reply_group']);
    return $comment_orl;
	}

	function updateListorder($comment_orl, $reply_group) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE comment SET ";

    if ( empty($reply_group) ) {		
      $__Db->query .= "listorder = comment_orl * -1 ";
      $__Db->query .= ",reply_group = comment_orl ";
    } else {
      $__Db->query .= "listorder = {$reply_group} * -1 ";
      $__Db->query .= ",reply_group = {$reply_group} ";
    }

		$__Db->query .= "WHERE comment_orl = {$comment_orl} LIMIT 1";
		$__Db->update();
	}

	function update($args) {
    $__Db = Db::getInstance();
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$update_datetime = _date();
		$__Db->query = "UPDATE comment SET
		  content = '{$args['content']}' 
		, content_text = '{$args['content_text']}' 
		, update_datetime = '{$update_datetime}' 
		, ipaddress = '{$ipaddress}' 
		WHERE comment_orl = {$args['comment_orl']} LIMIT 1";
		$__Db->update();
	}

	function updateReplySeq($reply_group, $reply_seq) {
    $__Db = Db::getInstance();
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$update_datetime = _date();
		$__Db->query = "UPDATE comment SET
		  reply_seq = reply_seq + 1 
		WHERE reply_group = {$reply_group} AND reply_seq > {$reply_seq} ";
		$__Db->update();
	}

	function updateGood($comment_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE comment SET
		good_count = good_count + 1
		WHERE comment_orl = {$comment_orl} LIMIT 1";
		$__Db->update();
	}
	
	function updateBad($comment_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE comment SET
		bad_count = bad_count + 1
		WHERE comment_orl = {$comment_orl} LIMIT 1";
		$__Db->update();
	}
	
	function updateAccuse($comment_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE comment SET
		accuse_count = accuse_count + 1
		WHERE comment_orl = {$comment_orl} LIMIT 1";
		$__Db->update();
	}
	
	function deleteOne($comment_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "DELETE FROM comment WHERE comment_orl = {$comment_orl} LIMIT 1 ";
		$__Db->result();
	}

	function deleteTargetOrl($module_orl, $target_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "DELETE FROM comment WHERE module_orl = {$module_orl} AND target_orl = {$target_orl} ";
		$__Db->result();
	}
}

?>
