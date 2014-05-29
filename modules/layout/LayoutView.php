<?php
/*
 @class LayoutView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class LayoutView {

  function dispLayoutAdminList() {
    $ModuleContext = ModuleContext::getInstance();
    $pages = _page_index(LayoutDAO::getCount());
    $list = LayoutDAO::select($pages['start_idx'],$pages['page_row']);
    $ModuleContext->put('pages',$pages);
    $ModuleContext->put('list',$list);
    return $ModuleContext;
  }

  function dispLayoutAdminInsert() {
    $ModuleContext = ModuleContext::getInstance();

    $layout_orl = _param('layout_orl');
    if ( !empty($layout_orl) ) $object = LayoutDAO::selectOnce($layout_orl);
    $ModuleContext->put('object',$object);
    $layout_list = ModuleHandler::getLayoutList();
    $ModuleContext->put('layout_list',$layout_list);
    return $ModuleContext;
  }

}

?>
