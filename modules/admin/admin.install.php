<?php
/*
 @class LayoutInstall

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class AdminInstall {

  // return true
  function moduleInstall() {
    global $GV;
    // 모듈 등록
    $args = array();
    $args['module'] = $GV['_ADMIN_']['MODULE'];
    $args['module_title'] = $GV['_ADMIN_']['TITLE'];
    $args['browser_title'] = $GV['_ADMIN_']['TITLE'];
    $args['layout_orl'] = 1;
    $args['locking'] = 'Y';
    ModuleObject::insertInstall($GV['_ADMIN_'], $args, $GV['_ADMIN_']['OPTIONS']);
    return true;
  }

}

?>
