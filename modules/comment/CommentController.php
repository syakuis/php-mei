<?php
/*
 @class CommentController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class CommentController {

  function procCommentInsert() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $M = $Context->getM();
    $GRANT = $Context->getGrant();

    if (!$GRANT['GRANT_WRITE']) $ModuleContext->resultError("권한이 없습니다.");

    $args = array();
    $module_orl = $M['module_orl'];
    $target_orl = _post('target_orl');
    $comment_orl = _post('comment_orl');
    $parent_orl = _post('parent_orl','0');
    $reply_group = _post('reply_group','0');
    $reply_depth = _post('reply_depth','0');
    $reply_seq = _post('reply_seq','0');
    $content = _post('content');
    $content_text = _post('content_text');

    $args['module_orl'] = $module_orl;
    $args['target_orl'] = $target_orl;
    $args['comment_orl'] = $comment_orl;
    $args['parent_orl'] = $parent_orl;
    $args['reply_group'] = $reply_group;
    $args['reply_depth'] = $reply_depth;
    $args['reply_seq'] = $reply_seq;
    $args['content'] = $content;
    $args['content_text'] = $content_text;

    $args['is_mobile'] = ($Context->getIsMobile() == TRUE) ? 'Y' : 'N';

    try {
      $__Db->begin();

      if ( empty($comment_orl) || $comment_orl == '0') {
          // 답글 인 경우
         if ( !empty($reply_group) && $reply_group != '0') {
           CommentDAO::updateReplySeq($reply_group,$reply_seq);
           $args['reply_depth'] = (int)$reply_depth + 1;
           $args['reply_seq'] = (int)$reply_seq + 1;
         }

        $comment_orl = CommentDAO::insert($args);
        DocumentObject::commentCrud($target_orl, false);

      } else {

        $rs = CommentDAO::selectOne($comment_orl);
        if ($rs['member_orl'] != $_SESSION['_SESS_MEMBER_ORL']) $ModuleContext->resultError("권한이 없습니다.");
        CommentDAO::update($args);

      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procCommentDelete() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $M = $Context->getM();
    $GRANT = $Context->getGrant();

    if (!$GRANT['GRANT_WRITE']) $ModuleContext->resultError("권한이 없습니다.");

    $target_orl = _post('target_orl');
    $comment_orl = _post('comment_orl');

    try {
      $__Db->begin();

      $rs = CommentDAO::selectOne($comment_orl);
      if ($rs['member_orl'] != $_SESSION['_SESS_MEMBER_ORL']) $ModuleContext->resultError("권한이 없습니다.");
      CommentObject::deleteOne($comment_orl, $target_orl);

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }


  function procCommentGoodUpdate() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();

    $module_orl = $Context->getM('module_orl');
    $target_orl = _post('target_orl');
    $comment_orl = _post('comment_orl');

    try {
      $__Db->begin();

      if(CommentObject::commentVotedLogUpdate($comment_orl, $module_orl, $target_orl, 1)) {
        CommentDAO::updateGood($comment_orl);
        $ModuleContext->setMessage('추천하였습니다.');
      } else {
        $ModuleContext->setMessage('중복 추천할 수 없습니다.');
        $ModuleContext->setError(TRUE);
      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procCommentBadUpdate() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();

    $module_orl = $Context->getM('module_orl');
    $target_orl = _post('target_orl');
    $comment_orl = _post('comment_orl');

    try {
      $__Db->begin();

      if(CommentObject::commentVotedLogUpdate($comment_orl, $module_orl, $target_orl, -1)) {
        CommentDAO::updateBad($comment_orl);
        $ModuleContext->setMessage('비추하였습니다.');
      } else {
        $ModuleContext->setMessage('중복 비추할 수 없습니다.');
        $ModuleContext->setError(TRUE);
      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

}

?>
