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

}

?>