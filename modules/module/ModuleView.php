<?php
/*
 @class ModuleView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class ModuleView {

  function dispModuleAdminSearchList() {
    $Context = Context::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context->setLayoutHidden(TRUE);
    
    $sch_module = _param('sch_module');
    $list = ModuleDAO::select($sch_module);

    $ModuleContext->put('list',$list);
    return $ModuleContext;
  }

}

?>
