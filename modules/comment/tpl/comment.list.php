<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$mid = $Context->getM('mid');
$module_orl = $ValueStack->get('comment', 'module_orl');
$target_orl = $ValueStack->get('comment', 'target_orl');
?>
<link rel="stylesheet" type="text/css" href="<?php echo $GV['_COMMENT_']['MODULE_R_PATH']?>/css/comment.css" />
<script type="text/javascript">

jQuery.comment._save_params = 'mid=<?php echo $mid?>&act=procCommentInsert&target_orl=<?php echo $target_orl?>';
jQuery.comment._del_params = 'mid=<?php echo $mid?>&act=procCommentDelete&target_orl=<?php echo $target_orl?>';

function go_login() {
  jQuery.member.login();
}

jQuery(function() {

  <?php if (!$GRANT['GRANT_LOGIN']) { ?>
  jQuery('#comment textarea').focus(function() {
    go_login();
  });
  <?php } ?>

  jQuery(".btn_comment_add").mousedown(function() {
    jQuery(this).attr("src","<?php echo $GV['_COMMENT_']['MODULE_R_PATH']?>/images/btn_registry_down.gif");
  }).mouseup(function() { jQuery(this).attr("src","<?php echo $GV['_COMMENT_']['MODULE_R_PATH']?>/images/btn_registry.gif"); });

});

</script>

<div id="comment">
<div class="cb_module cb_fluid">
  <h5 class="cb_h_type cb_h_type2">댓글 <span>(<strong id="comment_list_count"><?php echo $pages['total_count']?></strong>)</span></h5>

  <form id="form_comment_proc" method="post" action="?">
  </form>

  <!-- 입력 폼 -->
  <div class="cb_wrt cb_wrt_default">
    <div class="cb_wrt_box">
      <div class="cb_wrt_box2">
      <form id="form_comment" method="post" action="?">
      <input type="hidden" name="parent_orl" id="parent_orl" value="0"/>
      <input type="hidden" name="reply_group" id="reply_group" value="0"/>
      <input type="hidden" name="reply_depth" id="reply_depth" value="0"/>
      <input type="hidden" name="reply_seq" id="reply_seq" value="0"/>
      <fieldset>
      <legend>등록 폼</legend>
        <div class="cb_usr_area">
          <div class="cb_txt_area">
            <table cellspacing="0" border="1" class="cb_section">
            <caption>덧글 입력박스</caption>
            <col><col width="90">
            <thead>
            <tr>
            <th colspan="2" scope="col">유동형 덧글모듈</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>
              <textarea name="content" id="content"><?php if (!$GRANT['GRANT_LOGIN']) { ?>로그인 하셔야 댓글을 작성할 수 있습니다.<?php } ?></textarea>
            </td>
            <td class="cb_btn_area"><a href="javascript:<?php if ($GRANT['GRANT_LOGIN']) { ?>jQuery.comment.save('#form_comment');<?php } else { ?>go_login();<?php } ?>"><img src="<?php echo $GV['_COMMENT_']['MODULE_R_PATH']?>/images/btn_registry.gif" class="btn_comment_add"/></a></td>
            </tr>
            </tbody>
            </table>

          </div>
        </div>
      </fieldset>
      </form>
      </div>
    </div>
  </div>
  <!-- 입력 폼 -->

  <!-- 목록 -->
  <div class="cb_lstcomment">
    <ul>

    <?php
      foreach($list as $rs) {
        $comment_orl = $rs['comment_orl'];
        $parent_orl = $rs['parent_orl'];
        $reply_group = $rs['reply_group'];
        $reply_depth = $rs['reply_depth'];
        $reply_seq = $rs['reply_seq'];
        $member_orl = $rs['member_orl'];
        $is_mine = $rs['is_mine'];
        $user_id = $rs['user_id'];
        $nickname = $rs['nickname'];
        $content = $rs['content'];
        $content_text = $rs['content_text'];
        $ipaddress = $rs['ipaddress'];

        $good_count = $rs['good_count'];
        $bad_count = $rs['bad_count'];
        $accuse_count = $rs['accuse_count'];

        $reg_datetime = _date('$1/$2/$3 $4:$5',$rs['reg_datetime']);
        $update_datetime = $rs['update_datetime'];
     ?>
    <?php if ($reply_depth != 0) { ?>
    <li class="cb_thumb_off" id="comment_<?php echo $comment_orl?>" style="padding-left:10px;">
    <span class="cb_bu_subnode3">ㄴ</span>
    <?php } else { ?>
    <li class="cb_thumb_off" id="comment_<?php echo $comment_orl?>">
    <?php } ?>
      <div class="cb_comment_area">
        <a name="cmt_<?php echo $comment_orl?>"></a>
        <div class="cb_info_area">
          <div class="cb_section">
            <span class="cb_nick_name"><?php echo $nickname?></span>
            <span class="cb_usr_id">(<?php echo $user_id?>)</span>
            <span class="cb_date"><?php echo $reg_datetime?></span>
          </div>
          <div class="cb_section2">
            <span class="cb_nobar"><a class="c_reply_act" href="javascript:jQuery.comment.reply('<?php echo $comment_orl?>','<?php echo $reply_group?>','<?php echo $reply_depth?>','<?php echo $reply_seq?>');">답글</a></span>
            <?php if ($is_mine) { ?><span class="cb_nobar"><a class="c_update_act" href="javascript:jQuery.comment.update('<?php echo $comment_orl?>');">수정</a></span><span class="cb_nobar"><a class="c_del_act" href="javascript:jQuery.comment.del('<?php echo $comment_orl?>');">삭제</a></span><?php } ?>
          </div>
        </div>
        <div class="cb_dsc_comment">
          <p class="cb_dsc" id="c_content_<?php echo $comment_orl?>"><?php echo $content?></p>
          <p><a href="javascript:jQuery.comment.good_vote('<?php echo _param_pick("mid=&target_orl={$target_orl}&act=procCommentGoodUpdate&comment_orl={$comment_orl}")?>')">추천 (<?php echo $good_count?>)</a> / <a href="javascript:jQuery.comment.bad_vote('<?php echo _param_pick("mid=&target_orl={$target_orl}&act=procCommentBadUpdate&comment_orl={$comment_orl}")?>')">비추천 (<?php echo $bad_count?>)</a><p>
        </div>
        <!-- 숨김처리
        <div class="cb_info_area2">
          <a href="#">3개</a>의 답글이 있습니다.
        </div>
        //숨김처리 -->
      </div>
    </li>
    <?php } ?>

    </ul>
  </div>

  <?php if($M['options_is_comment_page'] == 'Y') { ?>
  <div class="paginate_complex" id="comment_navi">
    <a class="direction sprev start" href="#"><span></span><span></span>&nbsp;처음</a>
    <a class="direction sprev prev" href="#"><span></span>&nbsp;이전&nbsp;({page_link})</a>
    <span class="pageaction"></span>
    <a class="num" href="">{page}</a>
    <strong class="now">{page}</strong>
    <span class="div">&nbsp;</span>
    <a class="direction snext next" href="#">다음&nbsp;({page_link})&nbsp;<span></span></a>
    <a class="direction snext end" href="#">끝&nbsp;<span></span><span></span></a>
  </div>

  <script type="text/javascript">
  jQuery('#comment_navi').jaPageNavigator({
      name : 'cpage'
    , tag : '#comment'
    , page_row : "<?php echo $pages['page_row']?>"
    , page_link : "<?php echo $pages['page_link']?>"
    , page : "<?php echo $pages['page']?>"
    , total_count : "<?php echo $pages['total_page']?>"
  });
  </script>
  <?php } ?>
  <!-- 목록 -->

</div>

  <!-- 수정 폼 -->
  <div class="cb_wrt cb_wrt_default" id="comment_update" style="display:none;">
    <div class="cb_wrt_box">
      <div class="cb_wrt_box2">
      <form>
      <input type="hidden" name="comment_orl" id="comment_orl" />
      <fieldset>
      <legend>댓글 등록 폼</legend>
        <div class="cb_usr_area">
          <div class="cb_txt_area">
            <table cellspacing="0" border="1" class="cb_section">
            <caption>덧글 입력박스</caption>
            <col><col width="90">
            <thead>
            <tr>
            <th colspan="2" scope="col">유동형 덧글모듈</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>
              <textarea cols="80" rows="20" name="content" id="content"></textarea>
            </td>
            <td class="cb_btn_area">
              <img src="<?php echo $GV['_COMMENT_']['MODULE_R_PATH']?>/images/btn_registry.gif" id="update_btn" class="btn_comment_add" />
            </td>
            </tr>
            <tr>
            <td><div class="cb_dsc_area"><p class="cb_dsc cs-pointer cb_close" id="btn_comment_update_close">닫기</p></div></td>
            <td></td>
            </tr>
            </tbody>
            </table>

          </div>
        </div>
      </fieldset>
      </form>
      </div>
    </div>
  </div>
  <!-- 수정 폼 -->

<!-- 댓글 입력 폼 -->
<ul id="comment_reply" style="display:none;">
<li class="cb_thumb_off" style="padding-bottom:10px;">
<span class="cb_bu_subnode">ㄴ</span>

<div class="cb_wrt cb_wrt_default">
  <div class="cb_wrt_box">
    <div class="cb_wrt_box2">

    <form>
    <input type="hidden" name="parent_orl" id="parent_orl" value="0"/>
    <input type="hidden" name="reply_group" id="reply_group" value="0"/>
    <input type="hidden" name="reply_depth" id="reply_depth" value="0"/>
    <input type="hidden" name="reply_seq" id="reply_seq" value="0"/>

    <fieldset>
    <legend>댓글 등록 폼</legend>
      <div class="cb_usr_area">
        <div class="cb_txt_area">

          <table cellspacing="0" border="1" class="cb_section">
          <caption>덧글 입력박스</caption>
          <col><col width="90">
          <thead>
          <tr>
          <th colspan="2" scope="col">유동형 덧글모듈</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <td>
            <textarea cols="80" rows="20" name="content" id="content"><?php if(!$GRANT['GRANT_LOGIN']) { ?>로그인 하셔야 댓글을 작성할 수 있습니다.<?php } ?></textarea>
          </td>
          <td class="cb_btn_area">
            <img src="<?php echo $GV['_COMMENT_']['MODULE_R_PATH']?>/images/btn_registry.gif" id="reply_btn" class="btn_comment_add" />
          </td>
          </tr>
          <tr>
          <td><div class="cb_dsc_area"><p class="cb_dsc cs-pointer cb_close" id="btn_comment_reply_close">닫기</p></div></td>
          <td></td>
          </tr>
          </tbody>
          </table>

        </div>
      </div>
    </fieldset>
    </form>
    </div>
  </div>
</div>

</li>
</ul>
<!-- 댓글 입력 폼 -->

</div>
