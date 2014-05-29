<?php
/*
 @class MemberView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class MemberView {

  function dispMemberLogin() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();

    $ret_url = _param('ret_url',_MEI_R_PATH_);
    $ModuleContext->put('ret_url',$ret_url);

    // 레이아웃에 로그인 페이지가 있는 경우 해당 로그인 페이지 활성화
    $LAYOUT_PATH = $Context->getLayoutPath();
    if ( isset($LAYOUT_PATH['LAYOUT_PATH']) ) {
      $template = "{$LAYOUT_PATH['LAYOUT_PATH']}/{$ModuleContext->getTemplate()}";
      if ( file_exists($template) ) $ModuleContext->setSkinInfo('SKIN_FILE',$template);
    }

    return $ModuleContext;
  }

  function dispMemberSignup() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispMemberUpdate() {
    $ModuleContext = ModuleContext::getInstance();

    $member_orl = $_SESSION['_SESS_MEMBER_ORL'];
    $object = MemberDAO::selectOne($member_orl);
    $ModuleContext->put('object',$object);
    return $ModuleContext;
  }

  function dispMemberSearch() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispMemberOut() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispMemberAdminLogin() {
    $ModuleContext = ModuleContext::getInstance();
    $ret_url = _param('ret_url','./?module=admin');
    $ModuleContext->put('ret_url',$ret_url);
    return $ModuleContext;
  }

  function dispMemberAdminConfigInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();

    $skin_list = ModuleHandler::getSkinList($GV['_MEMBER_']['SKINS_PATH']);
    $ModuleContext->put('skin_list',$skin_list);

    $module_orl = $ModuleContext->getMod('module_orl');
    if ( !empty($module_orl) ) $object = ModuleObject::getConfig($module_orl);
    $object = _extend($GV['_MEMBER_']['OPTIONS'],$object);
    $ModuleContext->put('object',$object);

    // module_orl 정보를 읽어옴
    //$module = ModuleObject::getCacheModuleOrl($options_default_module);
    //$object['options_default_module_title'] = $module['module_title'];
    return $ModuleContext;
  }

  function dispMemberAdminList() {
    $ModuleContext = ModuleContext::getInstance();

    $pages = _page_index(MemberDAO::getCount());
    $list = MemberDAO::select($pages['start_idx'], $pages['page_row']);
    $ModuleContext->put('pages',$pages);
    $ModuleContext->put('list',$list);
    return $ModuleContext;
  }

  function dispMemberAdminInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $member_orl = _param('member_orl');
    if ( !empty($member_orl) ) $object = MemberDAO::selectOne($member_orl);
    $ModuleContext->put('object',$object);
    return $ModuleContext;
  }


}

?>
