<?php if (!defined("__SYAKU__")) exit; ?>
<div class="section_ul">
	<h2><em><?php echo $VAR['title']?></em>
</h2>
	<ul>
    <?php
      foreach($VAR['list'] as $rs) {
        $module_orl = $rs['module_orl'];
        $target_orl = $rs['target_orl'];
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

        $reg_datetime = _date('$2/$3',$rs['reg_datetime']);
        $update_datetime = $rs['update_datetime'];
     ?>
  <li>
  <a href="./?module=document&mid=<?php echo $module_orl?>&act=dispDocumentView&document_orl=<?php echo $target_orl?>#comment_<?php echo $comment_orl?>"><?php echo $content?></a>
  <span class="time"><?php echo $reg_datetime?></span></li>
  <?php } ?>
</ul>
</div>