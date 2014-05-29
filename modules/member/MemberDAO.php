<?php
/*
 @class Member

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class MemberDAO {
  //member_orl, user_id, user_name, nickname, password, temp_password, email, email_id, email_host, memo, is_admin, status, sid, login_sid, login_datetime, login_ipaddress, reg_datetime, update_datetime, listorder
    
  function getCount() {
    $__Db = Db::getInstance();
    // 총수
    $__Db->query = "SELECT IFNULL( COUNT(member_orl) , 0) AS count FROM member ";
  
    if ( !empty($this->sch_type) ) {
      $__Db->query .= " WHERE ";
  
      if ($this->sch_type == 'user_id') {
        $__Db->query .= " user_id LIKE '%{$this->sch_value}%' ";
      } elseif ($this->sch_type == 'user_name') {
        $__Db->query .= " user_name LIKE '%{$this->sch_value}%' ";
      } elseif ($this->sch_type == 'nickname') {
        $__Db->query .= " nickname LIKE '%{$this->sch_value}%' ";
      }
  
    }

    $rs = $__Db->object();
    return $rs['count'];
  }

  function getSearchUserId($user_name,$email) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT user_id FROM member ";
    $__Db->query .= "WHERE user_name = '{$user_name}' AND email = '{$email}'";

    $rs = $__Db->object();
    return $rs['user_id'];
  }

  function getSearchPassword($user_name,$user_id,$email) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT member_orl FROM member ";
    $__Db->query .= "WHERE user_name = '{$user_name}' AND user_id = '{$user_id}' AND email = '{$email}' LIMIT 1";

    $rs = $__Db->object();
    return $rs['member_orl'];
  }

  // 중복 체크
  function isUniqueUserId($user_id,$member_orl = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(member_orl) , 0) AS count FROM member ";
    $__Db->query .= "WHERE user_id = '{$user_id}' ";
    if ( !empty($member_orl) ) $__Db->query .= " AND member_orl <> {$member_orl} ";
    $rs = $__Db->object();
    return ($rs['count'] == 0);
  }

  // 중복 체크
  function isUniqueNickname($nickname,$member_orl = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(member_orl) , 0) AS count FROM member ";
    $__Db->query .= "WHERE nickname = '{$nickname}' ";
    if ( $member_orl != NULL ) $__Db->query .= " AND member_orl <> {$member_orl} ";
    $rs = $__Db->object();
    return ($rs['count'] == 0);
  }

  // 중복 체크
  function isUniqueEmail($email,$member_orl = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(member_orl) , 0) AS count FROM member ";
    $__Db->query .= "WHERE email = '{$email}' ";
    if ( !empty($member_orl) ) $__Db->query .= " AND member_orl <> {$member_orl} ";
    $rs = $__Db->object();
    return ($rs['count'] == 0);
  }

  function select($start_idx = NULL,$page_row = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM member ";
    
    $where = '';
    
    if ($this->sch_type == 'user_id') {
      $where .= "AND user_id LIKE '%{$this->sch_value}%' ";
    } elseif ($this->sch_type == 'user_name') {
      $where .= "AND user_name LIKE '%{$this->sch_value}%' ";
    } elseif ($this->sch_type == 'nickname') {
      $where .= "AND nickname LIKE '%{$this->sch_value}%' ";
    }

    $__Db->query .= $__Db->where($where);

    $__Db->query .= " ORDER BY listorder ";
    if ( !is_null($start_idx) && !is_null($page_row) ) $__Db->query .= " LIMIT {$start_idx},{$page_row} ";

    return $__Db->select();
  }
  
  function selectOne($value, $kind = 'member_orl') {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM member ";
    switch($kind) {
    	default : 
    	case 'member_orl' : 
    	$__Db->query .= " WHERE member_orl = {$value} LIMIT 1 ";
    	break;
    	case 'user_id' : 
    	$__Db->query .= " WHERE user_id = '{$value}' LIMIT 1 ";
    	break;
	    
    }
    return $__Db->object();
  }
  
  function insert($args) {
    $__Db = Db::getInstance();
    $email = explode("@",$args['email']);
    $email_id = $email[0];
    $email_host = $email[1];
    $args['email_id'] = $email_id;
    $args['email_host'] = $email_host;
    $args['reg_datetime'] = _date();

    $member_orl = $__Db->queryForInsert('member',$args);
    self::updateListorder($member_orl);
    return $member_orl;
  }

  function updateListorder($member_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "UPDATE member SET 
    listorder = member_orl * -1 
    WHERE member_orl = {$member_orl} LIMIT 1
    ";
    $__Db->update();
  }

  function update($args, $member_orl) {
    $__Db = Db::getInstance();
    $email = explode("@",$args['email']);
    $email_id = $email[0];
    $email_host = $email[1];
    $args['email_id'] = $email_id;
    $args['email_host'] = $email_host;
    $update_datetime = _date();
    $args['update_datetime'] = $update_datetime;
    $set = "WHERE member_orl = {$member_orl} LIMIT 1";
    $__Db->queryForUpdate('member',$args,$set);
  }

  function updateLogin($member_orl) {
    $__Db = Db::getInstance();
    $login_ipaddress = $_SERVER['REMOTE_ADDR'];
    $login_datetime = _date();
    $sid = session_id();

    $__Db->query = "UPDATE member SET 
    
    login_ipaddress = '{$login_ipaddress}',
    login_datetime = '{$login_datetime}',
    login_sid = '{$sid}'

    WHERE member_orl = {$member_orl} LIMIT 1
    ";
    $__Db->update();
  }

  function updateStatus($member_orl,$status) {
    $__Db = Db::getInstance();
    $update_datetime = _date();

    $__Db->query = "UPDATE member SET 
    status = '{$status}', 
    update_datetime = '{$update_datetime}' 
    WHERE member_orl = {$member_orl} LIMIT 1
    ";
    $__Db->update();
  }

  function updatePassword($member_orl,$password) {
    $__Db = Db::getInstance();
    $update_datetime = _date();

    $__Db->query = "UPDATE member SET 
    password = '{$password}', 
    update_datetime = '{$update_datetime}' 
    WHERE member_orl = {$member_orl} LIMIT 1
    ";
    $__Db->update();
  }
  function updateTempPassword($member_orl,$password = NULL, $temp_password = NULL) {
    $__Db = Db::getInstance();
    $temp_password = $__Db->value_format($temp_password);
    $update_datetime = _date();

    $__Db->query = "UPDATE member SET ";

    if ( !is_null($password) ) $__Db->query .= "password = '{$password}', ";

    $__Db->query .= "
    temp_password = {$temp_password}, 
    update_datetime = '{$update_datetime}' 
    WHERE member_orl = {$member_orl} LIMIT 1
    ";
    $__Db->update();
  }

  function del($member_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM member WHERE member_orl = {$member_orl} LIMIT 1";
    $__Db->del();
  }
}
?>
