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
    return LayoutDAO::selectOnce($layout_orl);
  }

}

?>
