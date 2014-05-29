<?php if (!defined("__SYAKU__")) exit; ?>
<div class="section_ul">
	<h2><em><?php echo $VAR['title']?></em>
</h2>
	<ul>
	<?php 
  foreach($VAR['list'] as $rs) {
    $document_orl = $rs['document_orl'];
    $forum_orl = $rs['forum_orl'];
    $forum_title = $rs['forum_title'];
    $subject = $rs['subject'];
    $is_notice = $rs['is_notice'];
    $is_bold = $rs['is_bold'];
    $color = $rs['color'];
    $style = $rs['style'];

    $content = $rs['content'];

    $member_orl = $rs['member_orl'];
    $user_id = $rs['user_id'];
    $nickname = $rs['nickname'];

    $readed_count = $rs['readed_count'];
    $file_count = $rs['file_count'];
    $comment_count = $rs['comment_count'];
    $good_count = $rs['good_count'];
    $bad_count = $rs['bad_count'];
    $accuse_count = $rs['accuse_count'];

    $reg_datetime = _date('$2/$3',$rs['reg_datetime']); 
    $ipaddress = $rs['ipaddress'];

    $subject_style = "";
    if ($is_bold == 'Y') { $subject_style .= 'font-weight :bold;'; }
    if ( !empty($color) ) { $subject_style .= " color :{$color};"; }
    if ( !empty($style) ) { $subject_style .= " {$style}"; }
  ?>
  <li>
  <?php if ( !empty($forum_title) ) { ?><span class="bu"><?php echo $forum_title?></span><?php } ?>
  <a href="<?php echo $rs['link']?>&act=dispDocumentView&document_orl=<?php echo $document_orl?>"><?php echo $subject?></a>
  <?php if ($rs['is_new']) { ?>
  &nbsp;<img src="<?php echo $GV['_DOCUMENT_']['MODULE_R_PATH']?>/images/bullet_new.gif" alt="새글" class="new">
  <?php } ?>
  <?php if ($rs['is_file']) { ?>
  &nbsp;<img src="<?php echo $GV['_DOCUMENT_']['MODULE_R_PATH']?>/images/bullet_disk.png" alt="파일" class="pic">
  <?php } ?>
  <?php if ($rs['is_comment']) { ?>
  &nbsp;<a href="<?php echo $rs['link']?>&act=dispDocumentView&document_orl=<?php echo $document_orl?>#comment" class="comment">[<?php echo $comment_count?>]</a>
  <?php } ?>
  <span class="time"><?php echo $reg_datetime?></span></li>
  <?php } ?>
</ul>
<a class="more" href="<?php echo $VAR['link']?>">더보기</a>
</div>