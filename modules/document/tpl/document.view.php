<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.header.php"; ?>

<?php
$document_orl = _param('document_orl');

if ($document_orl > 0) {
  $rs = $object;
  $file_result = $V['file_list'];

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

	$reg_datetime = _date('$1/$2/$3 $4:$5:$6',$rs['reg_datetime']); 
	$ipaddress = $rs['ipaddress'];
}

?>

<script type="text/javascript">
function document_voted(type) {
  var type_msg = (type == 'good') ? '추천 하시겠습니까?' : '추천 하시겠습니까?';
  jQuery('#form').jaAction({ 
    param : '<?php echo _param_pick("mid=&module=&act=procDocumentVotedUpdate")?>' + '&type=' + type,
    ask_msg : type_msg ,
    afterSend : function() {
      location.reload();
    }
  });
}

</script>

<div class="sub_column_content">
<form id="form" action="?" method="post">
<input type="hidden" id="document_orl" name="document_orl" value="<?php echo $document_orl?>" />
</form>

<table cellspacing="0" border="1" class="tbl_view">
<colgroup>
<col width="80"><col>
<col width="80"><col>
<col width="80"><col>
<col width="80"><col>
<col width="80"><col>
</colgroup>
<thead>
<tr>
<td colspan="10"><?php echo $subject?></td>
</tr>
</thead>
<tbody>
<tr>
<th scope="row">작성자</th>
<td><?php echo $nickname?></td>
<th scope="row">작성일</th>
<td><?php echo $reg_datetime?></td>
<th scope="row">조회</th>
<td><?php echo $readed_count?></td>
<th scope="row">추천</th>
<td><?php echo $good_count?></td>
<th scope="row">비추천</th>
<td><?php echo $bad_count?></td>
</tr>
<tr>
<td colspan="10" class="cont">

<div id="document_content">
<?php echo $content?>
</div>
<div style="margin-top:20px;text-align:center;">
<span class="button medium"><a href="javascript:document_voted('good');">추천 (<?php echo $good_count?>)</a></span>
<span class="button medium"><a href="javascript:document_voted('bad');">비추천 (<?php echo $bad_count?>)</a></span>
</div>

</td>
</tr>
<tr>
<td colspan="10">
<div>
<?php foreach($file_uploader_list as $rs) { ?>
<a href="<?php echo $GV['PATH']['FILES_R_PATH'].$rs['path']?>"><?php echo $rs['filename']?></a> (<?php echo $rs['size_unit']?>)
<?php } ?>

</div>
</td>
</tr>

</tbody>
</table>
</div>

<div style="margin-top:5px;">
<span class="button medium"><a href="./<?php echo _param_get('act=&document_orl=&cpage=','?')?>">목록</a></span>
<span class="button medium"><a href="./<?php echo _param_pick('mid=&module=&forum_orl=&act=dispDocumentInsert','?')?>">쓰기</a></span>
<?php if ($GRANT_MINE) { ?>
<script type="text/javascript">
function form_del() {
  jQuery('#form').jaAction({ 
    param : '<?php echo _param_pick("mid=&module=&act=procDocumentDelete")?>',
    ask : 'del' ,
    redirect : './<?php echo _param_pick('mid=&module=&forum_orl=','?')?>'
  });
}
</script>
<span class="button medium"><a href="./<?php echo _param_get('act=dispDocumentInsert','?')?>">수정</a></span>
<span class="button medium"><input type="button" onclick="form_del();" value="삭제" /></span>
<?php } ?>
</div>


<!-- 작성자 최근 글 -->
<div style="margin-top:5px;">
<div class="section_ul">
	<h2><em><?php echo $nickname?></em> 님 최근 게시글</h2>
	<ul>
<?php 
  foreach($user_list as $rs) { 
  	$reg_datetime = _date('$1/$2/$3 $4:$5:$6',$rs['reg_datetime']); 
?>
<li>
  <span class="bu"><?php echo $rs['forum_title']?></span>
  <a href="./<?php echo _param_get("act=dispDocumentView&forum_orl={$rs['forum_orl']}&document_orl={$rs['document_orl']}",'?')?>"><?php echo $rs['subject']?></a>
  <span class="time"><?php echo $reg_datetime?></span>
</li>
<?php } ?>

</ul>
</div>
</div>
<!-- 작성자 최근 글 -->


<?php if( $ModuleContext->getMod('options_is_comment') == 'Y' ) { ?><div style="margin-top:20px;"><?php echo $comment_content?></div><?php } ?>

<?php if($ModuleContext->getMod('options_view_listoutput') == 'Y') { ?><div style="margin-top:20px;"><?php echo $list_content?></div><?php } ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>