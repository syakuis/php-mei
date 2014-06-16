<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.header.php"; ?>

<div class="clearfix">
<div class="pull-left">
<p>Total <?php echo $pages['total_page']?>/<?php echo $pages['page']?></p>
</div>
<div class="pull-right">
<p>
<a class="btn btn-default btn-xs" href="./<?php echo _param_get('list_type=list','?')?>" role="button"><span class="glyphicon glyphicon-align-justify"></span></a>
<a class="btn btn-default btn-xs" href="./<?php echo _param_get('list_type=gallery','?')?>" role="button"><span class="glyphicon glyphicon-th-large"></span></a>
<a class="btn btn-default btn-xs" href="./<?php echo _param_get('list_type=media','?')?>" role="button"><span class="glyphicon glyphicon-list"></span></a>
<a class="btn btn-default btn-xs" href="./<?php echo _param_get('list_type=blog','?')?>" role="button"><span class="glyphicon glyphicon-file"></span></a>
</p>
</div>
</div>

<div class="row">
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
$content_text = $rs['content_text'];
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

$image_path = null;
if ( !empty($rs['images']) ) {
  $image_path = $GV['PATH']['FILES_R_PATH'] . $rs['images'][0]['path'];
}
?>

<div class="col-md-6">
<div class="panel panel-default">
  <div class="panel-body">

  <div class="media" style="height:100px;">
  <a class="pull-left" href="./<?php echo _param_get("act=dispDocumentView&document_orl={$document_orl}",'?')?>">
    <img class="media-object" src="<?php echo $image_path?>" style="height: 64px; width:64px;">
  </a>
  <div class="media-body">
    <h4 class="media-heading"><?php echo $subject?></h4>
    <p><span class="label label-default">조회 <?php echo $readed_count?></span>&nbsp;<span class="label label-default">추천 <?php echo $good_count?></span>&nbsp;<span class="label label-default">비추 <?php echo $bad_count?></span></p>
    <?php echo _cutstring($content_text,100)?>
    <?php echo $reg_datetime?>
  </div>
  </div>

  </div>
</div>
</div>

<?php }?>
<?php if ($pages['total_count'] == 0) { ?>
<?php }?>
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

<div class="row">
  <div class="col-xs-4">
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
  <div class="col-xs-8 text-right"><a class="btn btn-default" href="./<?php echo _param_pick('mid=&act=dispDocumentInsert','?')?>" role="button">쓰기</a></div>
</div>

<script type="text/javascript">
// parameter input create
jQuery.jaAction.paramCreateInput('#form_search','<?php echo _param_pick('mid=&module=','?')?>');
jQuery.ja.setValue("#form_search #sch_type","<?php echo _param('sch_type')?>");
</script>

<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>