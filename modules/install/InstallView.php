<?php
/*
 @class InstallView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class InstallView {

  function dispInstallLicense() {
    $ModuleContext = ModuleContext::getInstance();
    $license = file_get_contents(_MEI_PATH_ . '/LICENSE');
    $ModuleContext->put('license',$license);
    return $ModuleContext;
  }


  function dispInstallPrepare() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispInstallDbSetting() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispInstallStatus() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispInstallUserAdminInsert() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispInstallSuccess() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    if (!FileSystem::writeFile($Context->getPath('DATA_PATH') . '/config/installed.php','')) throw new Exception("파일 생성 실패");
    return $ModuleContext;
  }

  function dispInstallAdminList() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();

    // 인스톨 데이터 조회, 모듈 폴더 호출
    $list = InstallDAO::select();
    $modules = ModuleHandler::getModuleNames();
    $result = array();

    foreach($modules as $module) {
      $item = array();
      foreach($list as $rs) {
        if ($module == $rs['module']) {
          $item = $rs;
          break;
        }
      }

      $brief = $GV[ModuleHandler::getGVName($module)]['BRIEF'];
      if ( !empty($item) ) {
        $item['brief'] = $brief;
        array_push($result, $item);
      } else {
        array_push($result, array('module' => $module, 'brief' => $brief));
      }

    }

    $ModuleContext->put('list',$result);
    return $ModuleContext;
  }

}

?>