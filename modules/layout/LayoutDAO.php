<?php
/*
 @class LayoutDAO

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class LayoutDAO {
  //layout_orl, menu_orl, layout, title, header_script, extra_vars, is_mobile, reg_datetime

  function getCount() {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT IFNULL( COUNT(layout_orl) , 0) AS count FROM layout ";
    $rs = $__Db->object();
    return $rs['count'];
  }

  function select($start_idx = NULL, $page_row = NULL) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM layout ";
    $__Db->query .= " ORDER BY layout_orl DESC ";
    if ( !is_null($start_idx) && !is_null($page_row) ) $__Db->query .= " LIMIT {$start_idx},{$page_row} ";

    return $__Db->select();
  }
  
  function selectOnce($layout_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "SELECT * FROM layout WHERE layout_orl = {$layout_orl} LIMIT 1";
    return $__Db->object();
  }
  
  function insert($args) {
    $__Db = Db::getInstance();
    $reg_datetime = _date();
    $__Db->query = "INSERT INTO layout ( menu_orl, layout, title, header_script, extra_vars, is_mobile, reg_datetime ) values (
        {$args['menu_orl']}
      , '{$args['layout']}'
      , '{$args['title']}'
      , '{$args['header_script']}'
      , '{$args['extra_vars']}'
      , '{$args['is_mobile']}'
      , '{$reg_datetime}'
    )";
    
    $layout_orl = $__Db->insert();
    return $layout_orl;
  }

  function update($args) {
    $__Db = Db::getInstance();

    $__Db->query = "UPDATE layout SET
    layout = '{$args['layout']}' 
    , title = '{$args['title']}' 
    , header_script = '{$args['header_script']}' 
    , extra_vars = '{$args['extra_vars']}' 
    , is_mobile = '{$args['is_mobile']}' 
    WHERE layout_orl = {$args['layout_orl']} LIMIT 1";
    $__Db->update();
  }
  
  function del($layout_orl) {
    $__Db = Db::getInstance();
    $__Db->query = "DELETE FROM layout WHERE layout_orl = {$layout_orl} LIMIT 1 ";
    $__Db->del();
  }

}

?>
