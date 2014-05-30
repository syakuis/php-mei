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
    $ModuleContext->put('list', $V['list']);
    $ModuleContext->put('pages', $V['pages']);
    return $ModuleContext;
  }

  function dispPageAdminConfigInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV= $Context->getGV();

    $module_orl = _param('module_orl');
    $object = ModuleObject::getConfig($module_orl);
    $layout_list = LayoutObject::getConfigList();
    $skin_list = ModuleHandler::getSkinList($GV['_PAGE_']['SKINS_PATH']);
	$ModuleContext->put('object',$object);
	$ModuleContext->put('layout_list',$layout_list);
	$ModuleContext->put('skin_list',$skin_list);
    return $ModuleContext;
  }

  function dispPageAdminGrantInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $module_orl = _param('module_orl');
    $object = ModuleObject::getGrant($module_orl);
    $ModuleContext->put('object',$object);
    return $ModuleContext;
  }

}

?>
