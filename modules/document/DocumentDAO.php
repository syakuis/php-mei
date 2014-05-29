<?php
/*
 @class Document

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class DocumentDAO {
	//document_orl, module_orl, subject, is_notice, is_bold, color, style, content, content_text, member_orl, user_id, nickname, readed_count, file_count, comment_count, good_count, bad_count, accuse_count, is_mobile, state, reg_datetime, update_datetime, ipaddress, listorder

  /**
  * 게시물 총수
  */
	function getCount($args) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT IFNULL( COUNT(document_orl) , 0) AS count FROM document ";

    $where = '';
    if ( !is_null($args->module_orl) ) $where .= " AND module_orl = {$args->module_orl} ";
		if ( !empty($args->sch_type) ) $where .= " AND {$args->sch_type} LIKE '%{$args->sch_value}%' ";
    $__Db->query .= $__Db->where($where);
		$rs = $__Db->object();
		return $rs['count'];
	}

  /**
  * 게시물 목록
  */	
	function select($args, $start_idx = NULL, $page_row = NULL) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM document ";

    $where = '';
    if ( !is_null($args->module_orl) ) $where .= " AND module_orl = {$args->module_orl} ";
		if ( !empty($args->sch_type) ) $where .= " AND {$args->sch_type} LIKE '%{$args->sch_value}%' ";
    $__Db->query .= $__Db->where($where);
    
    if (is_null($args->order)) {
  		$__Db->query .= " ORDER BY is_notice DESC, listorder";
    } else {
  		$__Db->query .= " ORDER BY is_notice DESC, {$args->order}";
    }
    if ( !is_null($start_idx) && !is_null($page_row) ) $__Db->query .= " LIMIT {$start_idx},{$page_row} ";

		return $__Db->select();
	}

  /**
  * 게시자가 작성할 관련글 목록
  *
  * @param integer 현재 글 번호
  * @param integer 게시자 번호
  * @param integer 모듈 번호
  * @param integer 게시물 수
  * @return array
  */
	function selectUserDocument($document_orl, $member_orl, $module_orl = 0, $limit = 10) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM document ";
    $where = '';
    if ( !empty($module_orl) ) $where .= " AND module_orl = {$module_orl} ";
    $where .= " AND document_orl <> {$document_orl} ";
    $where .= " AND is_notice <> 'Y' ";
    $where .= " AND member_orl = {$member_orl} ";
    $__Db->query .= $__Db->where($where);
    $__Db->query .= " ORDER BY listorder";
    $__Db->query .= " LIMIT {$limit} ";
		return $__Db->select();
	}

  /**
  * 포틀릿 게시물 목록
  */
  function selectPortlet($module_orl = NULL, $limit=10) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM document ";
		$__Db->query .= " WHERE is_notice <> 'Y' AND state = 0 ";
    if ( !is_null($module_orl) ) $__Db->query .= " AND module_orl = {$module_orl} ";
		$__Db->query .= " ORDER BY listorder LIMIT {$limit} ";
		return $__Db->select();
  }
	
	function selectOne($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM document WHERE document_orl = {$document_orl} LIMIT 1";
		return $__Db->object();
	}
	
	function insert($args) {
    $__Db = Db::getInstance();
		$member_orl = $_SESSION['_SESS_MEMBER_ORL'];
		$user_id = $_SESSION['_SESS_USER_ID'];
		$nickname = $_SESSION['_SESS_NICKNAME'];
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$reg_datetime = _date();
		
		$__Db->query = "INSERT INTO document ( module_orl, subject, is_notice, is_bold, color, style, content, content_text, member_orl, user_id, nickname, file_count, is_mobile, reg_datetime, ipaddress ) values (
		    {$args['module_orl']}
		  , '{$args['subject']}'
		  , '{$args['is_notice']}'
		  , '{$args['is_bold']}'
		  , '{$args['color']}'
		  , '{$args['style']}'
		  , '{$args['content']}'
		  , '{$args['content_text']}'
		  , {$member_orl}
		  , '{$user_id}'
		  , '{$nickname}'
		  , {$args['file_count']}
		  , '{$args['is_mobile']}'
		  , '{$reg_datetime}'
		  , '{$ipaddress}'
		)";
    
    $document_orl = $__Db->insert();
    self::updateListorder($document_orl);
    return $document_orl;
	}

	function updateListorder($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET 
		listorder = document_orl * -1 
		WHERE document_orl = {$document_orl} LIMIT 1
		";
		$__Db->update();
	}

	function update($args) {
    $__Db = Db::getInstance();
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$update_datetime = _date();
		$__Db->query = "UPDATE document SET
		subject = '{$args['subject']}' 
		, is_notice = '{$args['is_notice']}' 
		, is_bold = '{$args['is_bold']}' 
		, color = '{$args['color']}' 
		, style = '{$args['style']}' 
		, content = '{$args['content']}' 
		, content_text = '{$args['content_text']}' 
		, update_datetime = '{$update_datetime}' 
		, ipaddress = '{$ipaddress}' 
		WHERE document_orl = {$args['document_orl']} LIMIT 1";
		$__Db->update();
	}

	function updateFileCount($document_orl, $file_count) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET
		file_count = {$file_count}
		WHERE document_orl = {$document_orl} LIMIT 1";
		$__Db->update();
	}

	function updateCommentCount($document_orl,$del) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET ";

    if ($del) {
      $__Db->query .= "comment_count = comment_count - 1 ";
    } else {
      $__Db->query .= "comment_count = comment_count + 1 ";
    }

    $__Db->query .= "WHERE document_orl = {$document_orl} LIMIT 1";
		$__Db->update();
	}

	function updateReadedCount($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET
		readed_count = readed_count + 1
		WHERE document_orl = {$document_orl} LIMIT 1";
		$__Db->update();
	}

	function updateGoodCount($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET
		good_count = good_count + 1
		WHERE document_orl = {$document_orl} LIMIT 1";
		$__Db->update();
	}
	
	function updateBadCount($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET
		bad_count = bad_count + 1
		WHERE document_orl = {$document_orl} LIMIT 1";
		$__Db->update();
	}
	
	function updateAccuseCount($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE document SET
		accuse_count = accuse_count + 1
		WHERE document_orl = {$document_orl} LIMIT 1";
		$__Db->update();
	}
	
	function del($document_orl) {
    $__Db = Db::getInstance();
		$__Db->query = "DELETE FROM document WHERE document_orl = $document_orl  LIMIT 1 ";
		$__Db->del();
	}

}

?>
