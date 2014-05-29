<?php
/*
 @class MainView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. ÃÖ¼®±Õ
* http://syaku.tistory.com
*/
class PageView {

  function dispPageView() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispPageAdminConfigList() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV= $Context->getGV();

    $V = ModuleObject::getList($GV['_PAGE_']['MODULE']);
    $ModuleContext->put('V',$V);
    return $ModuleContext;
  }

  function dispPageAdminConfigInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV= $Context->getGV();

    $module_orl = _param('module_orl');
    $V['object'] = ModuleObject::getConfig($module_orl);
    $V['layout_list'] = LayoutObject::getConfigList();
    $V['skin_list'] = ModuleHandler::getSkinList($GV['_PAGE_']['SKINS_PATH']);
    $ModuleContext->put('V',$V);
    return $ModuleContext;
  }

  function dispPageAdminGrantInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $module_orl = _param('module_orl');
    $V['object'] = ModuleObject::getGrant($module_orl);
    $ModuleContext->put('V',$V);
    return $ModuleContext;
  }

}

?>
