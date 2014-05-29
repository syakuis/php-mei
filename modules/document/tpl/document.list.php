<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.header.php"; ?>

<div class="sub_column_content">

<table cellspacing="0" border="1" class="tbl_type">
<colgroup>
<col width="80"><col><col width="115"><col width="85"><col width="60"><col width="60">
</colgroup>
<caption>Total <?php echo $pages['total_page']?>/<?php echo $pages['page']?>
  <ul>
    <?php if ($GV['GRANT_ADMIN']) { ?>
    <li><a href="?mid=admin&module=document&act=dispDocumentAdminList">admin</a></li>
    <?php } ?>
  </ul>
</caption>
<thead>
<tr>
<th scope="col">No</th>
<th scope="col">제목</th>
<th scope="col">작성자</th>
<th scope="col">등록일</th>
<th scope="col">조회수</th>
<th scope="col">추천수</th>
</tr>
</thead>
<tbody>

<?php
foreach($list as $rs) {
  $num = $rs['num'];
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

	$state = $rs['state'];

	$reg_datetime = _date('$1/$2/$3',$rs['reg_datetime']); 

  $ipaddress = $rs['ipaddress'];

  $subject_style = "";
  if ($is_bold == 'Y') { $subject_style .= 'font-weight :bold;'; }
  if ( !empty($color) ) { $subject_style .= " color :#{$color};"; }
  if ( !empty($style) ) { $subject_style .= " {$style}"; }
?>
<tr>
<td class="num"><?php echo $num?></td>
<td class="title">
<?php if ($GV['M']['options_is_forum'] == 'Y' && !empty($forum_title) ) { ?>[<?php echo $forum_title?>]&nbsp;<?php } ?>
<a href="./<?php echo _param_get("act=dispDocumentView&forum_orl={$forum_orl}&document_orl={$document_orl}",'?')?>"><span style="<?php echo $subject_style?>"><?php echo $subject?></span></a>
<?php if ($rs['is_new']) { ?>
<img src="<?php echo $GV['_DOCUMENT_']['MODULE_R_PATH']?>/images/bullet_new.gif" alt="새글" class="new">
<?php } ?>
<?php if ($rs['is_file']) { ?>
<img src="<?php echo $GV['_DOCUMENT_']['MODULE_R_PATH']?>/images/bullet_disk.png" alt="파일" class="pic">
<?php } ?>
<?php if ($rs['is_comment']) { ?>
<a href="./<?php echo _param_get("act=dispDocumentView&forum_orl={$forum_orl}&document_orl={$document_orl}",'?')?>#comment" class="comment">[<?php echo $comment_count?>]</a>
<?php } ?>
</td>
<td><?php echo $nickname ?></td>
<td class="date"><?php echo $reg_datetime ?></td>
<td class="hit"><?php echo $readed_count ?></td>
<td class="hit"><?php echo $good_count ?></td>
</tr>
<?php }?>
<?php if ($pages['total_count'] == 0) { ?>
<tr>
	<td colspan="6">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>

<div style="margin-top:5px;">
<span class="button medium"><a href="./<?php echo _param_pick('mid=&forum_orl=&module=&act=dispDocumentInsert','?')?>">쓰기</a></span>
</div>

<div class="paginate_complex" id="document_navi">
  <a class="direction sprev start" href="#"><span></span><span></span>&nbsp;처음</a>
  <a class="direction sprev prev" href="#"><span></span>&nbsp;이전&nbsp;({page_link})</a>
  <span class="pageaction"></span>
  <a class="num" href="">{page}</a>
  <strong class="now">{page}</strong>
  <span class="div">&nbsp;</span>
  <a class="direction snext next" href="#">다음&nbsp;({page_link})&nbsp;<span></span></a>
  <a class="direction snext end" href="#">끝&nbsp;<span></span><span></span></a>
</div>

<div class="content_search tc">
<form id="form_search" method="get" action="?">
  <fieldset>
      <select id="sch_type" name="sch_type">
        <option value="">검색</option>
        <option value="subject">제목</option>
        <option value="content_text">내용</option>
        <option value="nickname">닉네임</option>
        <option value="user_id">아이디</option>
      </select>
     <input type="text" class="i_search w200" id="sch_value" name="sch_value" value="<?php echo _param('sch_value')?>" />
     <span class="button medium"><input type="submit" value="검색" /></span>
  </fieldset>
</form>
</div>

<script type="text/javascript">
jQuery('#document_navi').jaPageNavigator({
    page_row : "<?php echo $pages['page_row']?>"
  , page_link : "<?php echo $pages['page_link']?>"
  , page : "<?php echo $pages['page']?>"
  , total_count : "<?php echo $pages['total_count']?>"
});

// parameter input create
jQuery.jaAction.paramCreateInput('#form_search','<?php echo _param_pick('mid=&forum_orl=&module=','?')?>');
jQuery.ja.setValue("#form_search #sch_type","<?php echo _param('sch_type')?>");
</script>

</div>

<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>