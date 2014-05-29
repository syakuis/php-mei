<?php
/*
 @class ModuleOptionsDAO

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class ModuleOptionsDAO {
  //module_orl, name, value

  function select($module_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM module_options ";
    $__Db->query .= " WHERE module_orl = {$module_orl} ";
    return $__Db->select();
  }
  
  function selectOnce($module_orl, $name) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM module_options WHERE module_orl = {$module_orl} AND name = '{$name}' LIMIT 1";
    return $__Db->object();
  }
  
  function insert($args) {	
    $__Db = Db::getInstance();
    $__Db->query = "INSERT INTO module_options ( module_orl, name, value ) values (
        {$args['module_orl']}
      , '{$args['name']}'
      , '{$args['value']}'
    )";
    
    $__Db->insert();
  }
  
  function del($module_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM module_options WHERE module_orl = {$module_orl} ";
    $__Db->del();
  }

}

?>
