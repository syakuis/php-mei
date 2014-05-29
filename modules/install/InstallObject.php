<?php
/*
 @class InstallObject

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class InstallObject {

  // install 테이블에 데이터 저장
  function saveInstall($args) {
    $module = $args['module'];

    $cond = array( 'module' => $module );
    $rs = InstallDAO::selectOne($cond);

    if ($rs) {
      InstallDAO::update($args, $cond);
    } else {
      $install_orl = InstallDAO::insert($args);
    }
    return $install_orl;
  }

}

?>
