<?php
/*
 @class LayoutObject

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class LayoutObject {

  // 레이아웃 목록 정보
  function getConfigList() {
    return LayoutDAO::select();
  }

  // 레이아웃 정보
  function getConfig($layout_orl) {
    $object = LayoutDAO::selectOnce($layout_orl);
    if ( !empty($object['extra_vars']) ) {
      $extra_vars = urldecode($object['extra_vars']);
      $extra_vars = json_decode($extra_vars, true);
      $object = array_merge($object, $extra_vars);
    }
    return $object;
  }

}

?>
