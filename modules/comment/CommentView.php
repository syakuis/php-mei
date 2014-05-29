<?php
/*
 @class CommentView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class CommentView {

  function dispCommentList() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $M = $Context->getM();
    $MOD = $ModuleContext->getMod();
    $ValueStack = ValueStack::getInstance();

    $module_orl = $ValueStack->get('comment', 'module_orl');
    $target_orl = $ValueStack->get('comment', 'target_orl');

    if ( empty($module_orl) || empty($target_orl) ) return "[ERROR] CommentView::dispCommentList=>Null Point Exception";

    $select_args = new stdClass();
    $select_args->module_orl = $module_orl;
    $select_args->target_orl = $target_orl;

    $pages = NULL;
    $pages['total_count'] = CommentDAO::getCount($select_args);
    if ( $M['options_is_comment_page'] == 'Y' ) {
      $cpage = _param('cpage','1');
      $page_row = _empty($M['options_comment_list_count'], $GV['_COMMENT_']['LIST_COUNT']);
      $page_link = _empty($M['options_comment_page_count'], $GV['_COMMENT_']['PAGE_COUNT']);
      $pages = _page_index($pages['total_count'], $cpage, $page_row, $page_link);
    }

    $list = array();
    $result = CommentDAO::select($select_args, $pages['start_idx'], $pages['page_row']);
    foreach($result as $rs) {
      $member_orl = $rs['member_orl'];
      $rs['is_mine'] = ($member_orl == $_SESSION['_SESS_MEMBER_ORL']);
      array_push($list,$rs);
    }

    // 스킨 설정
    $skin = _empty($M['options_comment_skin'], 'tpl'); // 기본스킨
    ModuleHandler::setSkinChange($skin);
    $ModuleContext->put('pages', $pages);
    $ModuleContext->put('list', $list);

    return $ModuleContext;
  }

}

?>
