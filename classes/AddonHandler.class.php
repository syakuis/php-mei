<?php
/*
 @class Document

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

class AddonHandler {
  private function __construct() { }
  private function __clone() { }

  function getList($addon) {
    global $GV;

    $list = array();
    $addons = dir( $GV['PATH']['ADDONS_PATH'] . "/{$addon}" );
    while ($addon = $addons->read()) {
      if (preg_match("/[A-Za-z0-9_]+$/i", $addon)) {
        array_push($list,$addon);
      }
    }

    return $list;
  }

}
?>