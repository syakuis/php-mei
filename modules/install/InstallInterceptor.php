<?php

class InstallInterceptor {

  function isInstalled() {
    $Context = Context::getInstance();
    if ( $Context->isInstalled() ) throw new Exception("이미 인스톨을 완료하였습니다.");
  }

}

?>