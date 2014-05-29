<?php
/*
@class FileUploader
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

class FileUploaderDAO {
  //file_orl, module_orl, seq, target_orl, num, sid, member_orl, user_id, filename, re_filename, folder, folder_date, size, extension, type, ipaddress, reg_datetime

  function selectOne($file_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM sk_file WHERE file_orl = {$file_orl} LIMIT 1 ";
    return $__Db->object();
  }

  // 대상 파일 총 용량
  function getFileSizeSum($module_orl, $seq, $sid, $target_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( SUM(size) , 0 ) AS f_size , IFNULL( COUNT(size) , 0 ) AS f_limit FROM sk_file WHERE module_orl = {$module_orl} AND seq = {$seq}";

    $target_orl = (int)$target_orl;
    if ( empty($target_orl) ) { // 처음 등록
      $__Db->query .= " AND sid = '{$sid}' AND target_orl = 0";
    } else { // 추가 등록
      $__Db->query .= " AND target_orl = {$target_orl}";
    }

    $rs = $__Db->object();

    $data['size'] = $rs['f_size'];
    $data['limit'] = $rs['f_limit'];

    return $data;
  }

  // 대상 파일 총수
  // _target_count
  function getFileCount($module_orl, $seq, $sid, $target_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(*) , 0 ) AS cnt FROM sk_file WHERE module_orl = {$module_orl} AND seq = {$seq}";
    
    $target_orl = (int)$target_orl;
    if ( empty($target_orl) ) { // 처음 등록
      $__Db->query .= " AND sid = '{$sid}' AND target_orl = 0 ";
    } else { // 추가 등록
      $__Db->query .= " AND target_orl = {$target_orl} ";
    }

    $rs = $__Db->object();
    return $rs['cnt'];
  }

  // 대상 파일 목록
  function selectTargetOrl($module_orl, $seq, $sid, $target_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM sk_file WHERE module_orl = {$module_orl} AND seq = {$seq} ";

    $target_orl = (int)$target_orl;
    if ( empty($target_orl) ) { // 대상이 없는 경우
      $__Db->query .= " AND target_orl = 0 AND sid = '{$sid}' ";
    } else {
      $__Db->query .= " AND target_orl = {$target_orl} ";
    }

    return $__Db->select();
  }

  // 대상 파일 조회
  // _object
  function selectOneTargetOrl($module_orl, $seq, $sid, $target_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM sk_file WHERE module_orl = '{$module_orl}' AND seq = {$seq} ";

    $target_orl = (int)$target_orl;
    if ( empty($target_orl) ) { // 대상이 없는 경우
      $__Db->query .= " AND target_orl = 0 AND sid = '{$sid}' ";
    } else {
      $__Db->query .= " AND target_orl = {$target_orl} ";
    }

    $__Db->query .= " LIMIT 1";

    return $__Db->object();
  }

  function insert($args) {
    $__Db = Db::getInstance();
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$reg_datetime = _date();

    $__Db->query = "INSERT INTO sk_file (module_orl, seq, target_orl, num, sid, member_orl, user_id, filename, re_filename, folder, folder_date, size, extension, type, ipaddress, reg_datetime) values ( 
     {$args['module_orl']}
    , {$args['seq']}
    , {$args['target_orl']}
    , {$args['num']} 
    , '{$args['sid']}'
    , {$args['member_orl']}
    , '{$args['user_id']}'
    , '{$args['filename']}'
    , '{$args['re_filename']}'
    , '{$args['folder']}'
    , '{$args['folder_date']}'
    , {$args['size']}
    , '{$args['extension']}'
    , '{$args['type']}'
    , '{$ipaddress}' 
    , '{$reg_datetime}' 
    )";

    $file_orl = $__Db->insert();
    return $file_orl;
  }

  function updateSid($module_orl, $seq, $sid, $target_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "UPDATE sk_file SET 
    target_orl = {$target_orl} 
    WHERE module_orl = {$module_orl} 
    AND seq = {$seq} 
    AND target_orl = 0 
    AND sid = '{$sid}' ";
    $__Db->update();
  }

  // _remove
  function deleteTargetOrl($module_orl, $seq, $target_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM sk_file WHERE module_orl = {$module_orl} AND seq = {$seq} ";
    $__Db->query .= " AND target_orl = {$target_orl} ";
    $__Db->del();
  }

  function deleteOne($file_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM sk_file WHERE file_orl = {$file_orl} LIMIT 1";
    $__Db->del();
  }

  function deleteSid($module_orl, $seq, $sid) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM sk_file WHERE module_orl = {$module_orl} AND seq = {$seq} ";
    $__Db->query .= " AND target_orl = 0 AND sid = '{$sid}' ";
    $__Db->del();
  }

}

?>