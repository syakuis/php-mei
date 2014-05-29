<?php
/*
 @class ModuleDAO

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class ModuleDAO {
  //module_orl, module, mid, module_title, browser_title, skin, layout_orl, menu_orl, header_content, footer_content, locking, reg_datetime
  

  function getCount($module = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(module_orl) , 0) AS count FROM module ";
    if (!is_null($module)) $__Db->query .= " WHERE module = '{$module}' ";
    $rs = 	$__Db->object();
    return $rs['count'];
  }

  function select($module = NULL, $start_idx = NULL, $page_row = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM module ";
    if (!is_null($module)) $__Db->query .= " WHERE module = '{$module}' ";
    $__Db->query .= " ORDER BY module_orl DESC ";
    if ( !is_null($start_idx) && !is_null($page_row)) $__Db->query .= " LIMIT {$start_idx},{$page_row} ";
    return $__Db->select();
  }
  
  function selectOne($value, $set = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM module";

    switch ($set) {
      case 'mid' : $__Db->query .= " WHERE mid = '{$value}' LIMIT 1 "; break;
      case 'module' : $__Db->query .= " WHERE module = '{$value}' AND (mid IS NULL OR mid = '' ) LIMIT 1 "; break;
      default : 
      case 'module_orl' :
        $__Db->query .= " WHERE module_orl = {$value} LIMIT 1 ";
      break;
    }

    return $__Db->object();
  }

  function getModuleOrl($mid) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT module_orl FROM module WHERE mid = '{$mid}' LIMIT 1 ";
    $rs = $__Db->object();
    return $rs['module_orl'];
  }

  function getMid($module_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT mid FROM module WHERE module_orl = {$module_orl} LIMIT 1 ";
    $rs = $__Db->object();
    return $rs['mid'];
  }

  // 유일한 mid 인 경우 true 아닌 경우 false
  function isUniqueMid($mid,$module_orl = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(mid) , 0) AS count FROM module ";
    $__Db->query .= "WHERE mid = '{$mid}' ";
    if ( !empty($module_orl) ) $__Db->query .= " AND module_orl <> {$module_orl} ";
    $rs = $__Db->object();
    return $rs['count'] == 0;
  }
  
  function insert($args) {
    $__Db = Db::getInstance();
    $layout_orl = _empty($args['layout_orl'], '0');
    $locking = _empty($args['locking'], 'N');
    $reg_datetime = _date();
    
    $__Db->query = "INSERT INTO module ( module, mid, module_title, browser_title, skin, layout_orl, menu_orl, header_content, footer_content, locking, reg_datetime ) values (
      '{$args['module']}'
    , '{$args['mid']}'
    , '{$args['module_title']}'
    , '{$args['browser_title']}'
    , '{$args['skin']}'
    , {$layout_orl}
    , 0
    , '{$args['header_content']}'
    , '{$args['footer_content']}'
    , '$locking'
    , '{$reg_datetime}'
    )";
    
    $module_orl = $__Db->insert();
    return $module_orl;
  }

  function update($args) {
    $__Db = Db::getInstance();
    $__Db->query = "UPDATE module SET
    mid = '{$args['mid']}' 
    , module_title = '{$args['module_title']}' 
    , browser_title = '{$args['browser_title']}' 
    , skin = '{$args['skin']}' 
    , layout_orl = {$args['layout_orl']} 
    , header_content = '{$args['header_content']}' 
    , footer_content = '{$args['footer_content']}' 
    WHERE module_orl = {$args['module_orl']} LIMIT 1";
    $__Db->result();
  }
  
  function del($module_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM module WHERE module_orl = $module_orl AND locking = 'N' LIMIT 1 ";
    $__Db->result();
  }

}

?>
