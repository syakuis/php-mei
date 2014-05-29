<?php
/*
 @class CommentObject

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class CommentObject {

  // 댓글 삭제
  function deleteOne($comment_orl, $target_orl) {
    if (empty($comment_orl) || empty($target_orl) ) throw new Exception("Null Point Exception");
    // 댓글 삭제
    CommentDAO::deleteOne($comment_orl);

    // 추천 & 비추천 삭제
    CommentVotedLogDAO::deleteOne($comment_orl);

    // 게시글 댓글 수 수정
    DocumentObject::commentCrud($target_orl, true);
  }

  // 대상 댓글 삭제
  function deleteTargetOrl($module_orl, $target_orl) {
    if ( empty($module_orl) || empty($target_orl) ) throw new Exception("Null Point Exception");
    // 댓글 삭제
    CommentDAO::deleteTargetOrl($module_orl, $target_orl);
    // 추천 & 비추천 삭제
    CommentVotedLogDAO::deleteTargetOrl($module_orl, $target_orl);
  }


  function commentVotedLogUpdate($comment_orl, $module_orl, $target_orl, $vote) {
    
    $args = new stdClass();
    $args->comment_orl = $comment_orl;
    $args->module_orl = $module_orl;
    $args->target_orl = $target_orl;
    $args->vote = $vote;
    $args->member_orl = $_SESSION['_SESS_MEMBER_ORL'];

    if ( !CommentVotedLogDAO::isUserVoted($comment_orl, $args->member_orl) && !empty($args->member_orl) ) {
      CommentVotedLogDAO::insert($args);
      return true;
    }

    return false;
  }


}

?>
