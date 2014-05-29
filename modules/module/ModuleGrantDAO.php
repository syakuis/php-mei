<?php
/*
 @class ModuleGrantDAO

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class ModuleGrantDAO {
  //module_orl, name, group_orl
  
  function select($module_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM module_grant ";
    $__Db->query .= " WHERE module_orl = {$module_orl} ";
    return $__Db->select();
  }
    
  function insert($args) {	
    $__Db = Db::getInstance();
    $__Db->query = "INSERT INTO module_grant ( module_orl, name, group_orl ) values (
      '{$args['module_orl']}'
    , '{$args['name']}'
    , '{$args['group_orl']}'
    )";
    
    $__Db->insert();
  }
  
  function del($module_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM module_grant WHERE module_orl = $module_orl";
    $__Db->del();
  }

}

?>
