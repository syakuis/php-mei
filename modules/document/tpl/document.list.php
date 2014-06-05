<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.header.php"; ?>

<div class="panel panel-default clearfix">
<div class="panel-body">Total <?php echo $pages['total_page']?>/<?php echo $pages['page']?></div>

<table class="table table-hover">
<colgroup>
<col width="60"><col><col width="115"><col width="85"><col width="60"><col width="60">
</colgroup>
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
<td class="num"><?php if ($rs['is_notice'] == 'Y') { ?><span class="label label-primary">공지</span><?php } else { ?><?php echo $num?><?php } ?></td>
<td class="title">
<a href="./<?php echo _param_get("act=dispDocumentView&document_orl={$document_orl}",'?')?>"><span style="<?php echo $subject_style?>"><?php echo $subject?></span></a>
<?php if ($rs['is_new']) { ?>&nbsp;<span class="label label-danger">새글</span><?php } ?>
<?php if ($rs['is_file']) { ?>&nbsp;<span class="label label-info">첨부&nbsp;<?php echo $file_count?></span><?php } ?>
<?php if ($rs['is_comment']) { ?>&nbsp;<a href="./<?php echo _param_get("act=dispDocumentView&document_orl={$document_orl}",'?')?>#comment" class="comment"><span class="label label-default">댓글&nbsp;<?php echo $comment_count?></span></a><?php } ?>&nbsp;
</td>
<td><?php echo $nickname ?></td>
<td><?php echo $reg_datetime ?></td>
<td><?php echo $readed_count ?></td>
<td><?php echo $good_count ?></td>
</tr>
<?php }?>
<?php if ($pages['total_count'] == 0) { ?>
<tr>
	<td colspan="6">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>

</div>

<div class="text-center">

<ul class="pagination pagination-sm" id="document_navi">
  <li class="prev"><a href="#">&laquo;</a></li>
  <li class="disabled prevx"><a href="#">&laquo;</a></li>
  <span class="pageaction"></span>
  <li class="num"><a href="#">{page}</a></li>
  <li class="active now"><a href="#">{page} <span class="sr-only">(current)</span></a></li>
  <li class="next"><a href="#">&raquo;</a></li>
  <li class="disabled nextx"><a href="#">&raquo;</a></li>
</ul>

<script type="text/javascript">
  jQuery('#document_navi').jaPageNavigator({
    page_row : "<?php echo $pages['page_row']?>"
  , page_link : "<?php echo $pages['page_link']?>"
  , page : "<?php echo $pages['page']?>"
  , total_count : "<?php echo $pages['total_count']?>"
  });
</script>

</div>

<div class="clearfix">
<div class="pull-left">
<form id="form_search" method="get" action="?">
<div class="input-group">
  <span class="input-group-addon">
    <select id="sch_type" name="sch_type" style="font-size:11px;">
    <option value="">검색</option>
    <option value="subject">제목</option>
    <option value="content_text">내용</option>
    <option value="nickname">닉네임</option>
    <option value="user_id">아이디</option>
    </select>
  </span>
  <input type="text" class="form-control" id="sch_value" name="sch_value" value="<?php echo _param('sch_value')?>" />
  <span class="input-group-btn"><button class="btn btn-default" type="submit">검색</button></span>
</div>
</form>
</div>

<div class="pull-right">
  <a class="btn btn-default" href="./<?php echo _param_pick('mid=&act=dispDocumentInsert','?')?>" role="button">쓰기</a>
</div>
</div>

<script type="text/javascript">
// parameter input create
jQuery.jaAction.paramCreateInput('#form_search','<?php echo _param_pick('mid=&module=','?')?>');
jQuery.ja.setValue("#form_search #sch_type","<?php echo _param('sch_type')?>");
</script>

<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>