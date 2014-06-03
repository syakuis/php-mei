<?php
/*
 @class LayoutController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class LayoutController {

  function procLayoutAdminInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $args = array();
    $layout_orl = _param('layout_orl',NULL,'POST');
    $args['layout_orl'] = $layout_orl;
    $args['menu_orl'] = _param('menu_orl','0','POST');
    $args['layout'] = _param('layout',NULL,'POST');
    $args['title'] = _param('title',NULL,'POST');
    $args['header_script'] = _param('header_script',NULL,'POST');
    $args['is_mobile'] = _param('is_mobile','N','POST');
    $extra_vars = _array_strpos($_POST,'options_', FALSE, TRUE);
    $args['extra_vars'] = (!empty($extra_vars)) ? json_encode($extra_vars) : '';

    try {
      $__Db->begin();

      if ( empty($layout_orl) ) {
        LayoutDAO::insert($args);
      } else {
        LayoutDAO::update($args);
      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }


  function procLayoutAdminDelete() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $layout_orl = _param('layout_orl',NULL,'POST');

    try {
      $__Db->begin();

      LayoutDAO::del($layout_orl);

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

}

?>
