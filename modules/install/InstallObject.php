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

  // 모듈 설치
  function moduleInstall($module) {

    // 설치여부 체크
    $cond = array( 'module' => $module );
    $install_rs = InstallDAO::selectOne($cond);

    if ($install_rs && $install_rs['status'] == 'Y') return true;

    // 설치 모듈 검색
    $module_gv = $GV[ModuleHandler::getGVName($module)];
    $module_path = $module_gv['MODULE_PATH'] . "/{$module}.install.php";
    if ( file_exists($module_path) ) require_once $module_path;

    // 모듈 설치 호출
    $module_class = $module . 'Install';
    if ( class_exists($module_class) ) {
      // 클래스 선언
      $func = create_function('', "return new {$module_class}();");
      $cls = $func();
      if( is_object($cls) ) {
        if ( method_exists($cls,'moduleInstall') ) {
          $cls->moduleInstall();
          $args = array();
          $args['module'] = $module;
          $args['status'] = 'Y';
          $args['reg_datetime'] = _date();
          self::saveInstall($args);
          return true;
        }
      }
    }

    return false;
  }

  // 설치 메서드가 없거나 설치 모듈이 없는 경우 기본설치로 진행
  function moduleAutoInstall($module) {
    $Context = Context::getInstance();
    $GV = $Context->getGV();

    $name = ModuleHandler::getGVName($module);

    // 모듈 설치 ( 싱글인 경우)
    if ($GV[$name]['SINGLE'] == true) {
      $args = array();
      $args['module'] = $GV[$name]['MODULE'];
      $args['module_title'] = $GV[$name]['TITLE'];
      $args['browser_title'] = $GV[$name]['TITLE'];
      $args['locking'] = 'Y';
      ModuleObject::insertInstall($GV[$name], $args, $GV[$name]['OPTIONS']);
    }

    $args = array();
    $args['module'] = $module;
    $args['status'] = 'Y';
    $args['reg_datetime'] = _date();
    InstallObject::saveInstall($args);

  }

}

?>
