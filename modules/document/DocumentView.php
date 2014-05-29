<?php
/*
 @class DocumentView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class DocumentView {

  function widgDocumentList($length = 0,$limit = 10,$mid = NULL,$forum_orl = NULL,$title = NULL,$widget = 'default') {
    $GV = $GLOBALS['GV'];
    $__Db = Db::getInstance();
    $__Document = $GLOBALS['__Document'];
    $__Forum = $GLOBALS['__Forum'];

    $module_orl = NULL;

    if ($mid != NULL) {
      $__ModuleObject = $GLOBALS['__ModuleObject'];
      $VAR['M'] = $__ModuleObject->getConfig($mid,'mid');

      $module_orl = $VAR['M']['module_orl'];

      if ( $VAR['M']['options_is_forum'] == 'Y' ) {
        $VAR['FORUM'] = $__Forum->_object($forum_orl);
        if ( $title == NULL ) $title = $VAR['FORUM']['forum_title'];
      }

      if ( $title == NULL ) $title = $VAR['M']['module_title'];

    }

    // 링크 생성
    $VAR['title'] = $title;
    $VAR['mid'] = $mid;

    $VAR['link'] = './?module=document';
    if ( $mid != NULL ) $VAR['link'] .= "&mid={$mid}";

    $VAR['list'] = array();
    $result = $__Document->_portlet_list($module_orl,$forum_orl,$limit);

    while($rs = $__Db->fetch($result)) {
      if ( $mid == NULL ) { $rs['link'] = $VAR['link'] . "&mid={$rs['module_orl']}&forum_orl={$rs['forum_orl']}"; }
      else { $rs['link'] = $VAR['link'] . "&forum_orl={$rs['forum_orl']}"; }

      // 새글 표시
      $is_new = _new_display($rs['reg_datetime']);
      $rs['is_new'] = ($is_new && strpos($VAR['M']['options_icons'],'new') > -1);
      // 첨부파일 존재 유무
      $rs['is_file'] = ($rs['file_count'] > 0 && strpos($VAR['M']['options_icons'],'file') > -1);
      // 댓글 존재 유무
      $rs['is_comment'] = ($rs['comment_count'] > 0 && $VAR['M']['options_is_comment'] == 'Y');

      if ($length > 0) $rs['subject'] = cut_str($rs['subject'],$length);
      array_push($VAR['list'],$rs);
    }

    ob_start();
    include $GV['_DOCUMENT_']['MODULE_PATH'] . "/widgets/{$widget}/widget.php";
    $view = ob_get_contents();
    ob_end_clean();

    return $view;
  }

  function dispDocumentList() {
    $M = ModuleContext::getInstance();
    $C = Context::getInstance();
    $GV = $C->getGV();
    $MOD = $M->getMod();

    if (!$C->getGrant('GRANT_LIST')) $M->resultError("접속 권한이 없습니다.");

    $sch_type = _param('sch_type');
    $sch_value = _param('sch_value');

    $args = new stdClass();
    $args->module_orl = $MOD['module_orl'];
    $args->sch_type = $sch_type;
    $args->sch_value = $sch_value;

    $page_row = _empty($MOD['options_list_count'], $GV['_DOCUMENT_']['LIST_COUNT']);
    $page_link = _empty($MOD['options_page_count'], $GV['_DOCUMENT_']['PAGE_COUNT']);
    $pages = _page_index(DocumentDAO::getCount($args), NULL, $page_row, $page_link);

    if ( !empty($MOD['options_order_target']) && !empty($MOD['options_order_type']) ) {
      $args->order = "{$MOD['options_order_target']} {$MOD['options_order_type']}";
    }
    
    $result = DocumentDAO::select($args, $pages['start_idx'], $pages['page_row']);
    $cnt = 0;
    $list = array();
    foreach($result as $rs) {
      
      $rs['num'] = $pages['virtual_idx'] - $cnt;
      if ($rs['is_notice'] == 'Y') { $rs['num'] = '공지'; }
      // 새글 표시
      $is_new = _new_display($rs['reg_datetime']);
      $rs['is_new'] = ($is_new && strpos($MOD['options_icons'],'new') > -1);
      // 첨부파일 존재 유무
      $rs['is_file'] = ($rs['file_count'] > 0 && strpos($MOD['options_icons'],'file') > -1);
      // 댓글 존재 유무
      $rs['is_comment'] = ($rs['comment_count'] > 0 && $MOD['options_is_comment'] == 'Y');
      array_push($list,$rs);
      $cnt++;
    }

    $M->put('list',$list);
    $M->put('pages',$pages);

    return $M;
  }

  function dispDocumentView() {
    $M = ModuleContext::getInstance();
    $C = Context::getInstance();
    $GV = $C->getGV();

    if (!$C->getGrant('GRANT_VIEW')) $M->resultError("접속 권한이 없습니다.");

    $mid = _param('mid');
    $module_orl = $M->getMod('module_orl');
    $document_orl = _param('document_orl');

    if ( !empty($document_orl) ) {
      $GLOBALS['GV']['M']['target_orl'] = $document_orl;

      // 조회수 업데이트
      DocumentObject::documentReadedUpdate($document_orl, $module_orl);
      $object = DocumentDAO::selectOne($document_orl);

      // 타이틀 명
      $C->setBrowser_title($object['subject']);

      // 권한변경
      $member_orl = $object['member_orl'];
      if ($member_orl == $_SESSION['_SESS_MEMBER_ORL']) $M->put('GRANT_MINE',true);

      $file_uploader_list = FileUploaderObject::getFileExistsList($module_orl, '0', $document_orl);
      $M->put('file_uploader_list',$file_uploader_list);

      if($M->getMod('options_is_comment') == 'Y') {
        $ValueStack = ValueStack::getInstance();
        $ValueStack->put('comment', 'module_orl', $module_orl);
        $ValueStack->put('comment', 'target_orl', $document_orl);

        $comment_content = ModuleHandler::getModuleContent('module', 'comment', 'dispCommentList');
        $M->put('comment_content',$comment_content);
      }

      $user_list = DocumentDAO::selectUserDocument($document_orl, $member_orl);
      $M->put('user_list',$user_list);
    }

    if($M->getMod('options_view_listoutput') == 'Y') {
      $list_content = ModuleHandler::getModuleContent('mid', $mid, 'dispDocumentList');
      $M->put('list_content',$list_content);
    }

    $M->put('object',$object);
    return $M;
  }

  function dispDocumentInsert() {
    $M = ModuleContext::getInstance();
    $C = Context::getInstance();
    $GV = $C->getGV();
    if (!$C->getGrant('GRANT_WRITE')) $M->resultError("접속 권한이 없습니다.");
    $document_orl = _param('document_orl');
    $module_orl = $M->getMod('module_orl');

    if ( !empty($document_orl) ) {
      $object = DocumentDAO::selectOne($document_orl);
      $M->put('object', $object);

      if ($object) {
        $member_orl = $object['member_orl'];
        if ($member_orl == $_SESSION['_SESS_MEMBER_ORL']) $M->put('GRANT_MINE',true);
      }
    }

    if($M->getMod('options_is_file') == 'Y') {
      $ValueStack = ValueStack::getInstance();
      $ValueStack->put('file_uploader', 'module_orl', $module_orl);
      $ValueStack->put('file_uploader', 'target_orl', $document_orl);
      $ValueStack->put('file_uploader', 'seq', 0);
      $ValueStack->put('file_uploader', 'file_upload_multi', true);

      $file_uploader_content = ModuleHandler::getModuleContent('module', 'file_uploader', 'dispFileUploaderInsert');
      $M->put('file_uploader_content',$file_uploader_content);
    }
    return $M;
  }


  function dispDocumentAdminConfigList() {
    $M = ModuleContext::getInstance();
    $C = Context::getInstance();
    $GV = $C->getGV();

    $V = ModuleObject::getList($GV['_DOCUMENT_']['MODULE']);
    $M->put('list', $V['list']);
    $M->put('pages', $V['pages']);

    return $M;
  }

  function dispDocumentAdminConfigInsert() {
    $M = ModuleContext::getInstance();
    $C = Context::getInstance();
    $GV = $C->getGV();

    $module_orl = _param('module_orl');
    if ( !empty($module_orl) ) $object = ModuleObject::getConfig($module_orl);
    $object = _extend($GV['_DOCUMENT_']['OPTIONS'],$object);

    $layout_list = LayoutObject::getConfigList();
    $skin_list = ModuleHandler::getSkinList($GV['_DOCUMENT_']['SKINS_PATH']);
    $editor_list = AddonHandler::getList('editor');
	$comment_skin_list = ModuleHandler::getSkinList($GV['_COMMENT_']['SKINS_PATH']);

    $M->put('object', $object);
    $M->put('layout_list', $layout_list);
    $M->put('skin_list', $skin_list);
    $M->put('editor_list', $editor_list);
    $M->put('comment_skin_list', $comment_skin_list);

    return $M;
  }

  function dispDocumentAdminGrantInsert() {
    $M = ModuleContext::getInstance();
    $module_orl = _param('module_orl');
    $object = ModuleObject::getGrant($module_orl);
    $M->put('object', $object);

    return $M;
  }

}

?>
