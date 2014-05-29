<?php
/*
 @class InstallDAO

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

// 데이터 조회, 추가, 수정, 삭제 기본적인 함수만 제공
class InstallDAO {
	//install_orl, module, status, reg_datetime, update_datetime

  function select($start_idx = NULL, $page_row = NULL) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM install ";
		if ( !is_null($start_idx) && !is_null($page_row) ) $__Db->query .= " LIMIT {$start_idx},{$page_row} ";
		return $__Db->select();
  }

	
	function getCount($args = array()) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT IFNULL( COUNT(install_orl) , 0) AS count FROM install ";
    $where = '';
    if (array_key_exists('module', $args)) $where .= "AND module = '{$args['module']}' ";
		$__Db->query .= $__Db->where($where);
		$rs = 	$__Db->object();
		return $rs['count'];
	}

  function selectOne($args) {
    $__Db = Db::getInstance();
		$__Db->query = "SELECT * FROM install ";
    $where = '';
    if (array_key_exists('module', $args)) $where .= "AND module = '{$args['module']}' ";
		$__Db->query .= $__Db->where($where);
		return $__Db->object();
  }

  function insert($args) {
    $__Db = Db::getInstance();
		
    $__Db->query = "INSERT INTO install ( module, status, reg_datetime ) values (
      '{$args['module']}'
    , '{$args['status']}'
    , '{$args['reg_datetime']}'
		)";

    return $__Db->insert();
  }


	function update($args, $set) {
    $__Db = Db::getInstance();
		$__Db->query = "UPDATE install SET
      status = '{$args['status']}' 
    , reg_datetime = '{$args['reg_datetime']}' 
    , update_datetime = '{$args['update_datetime']}'
    WHERE module = '{$set['module']}' LIMIT 1";
		$__Db->update();
	}

  function insertModule($values) {
    $__Db = Db::getInstance();
    $doc = array( 
      'field' => array( 'module' , 'reg_datetime' ) ,
      'value' => $values 
    );
    $__Db->queryForInsert('install',$doc);
  }

}
?>
