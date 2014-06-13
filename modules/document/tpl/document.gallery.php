<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.header.php"; ?>
<style>
.thumbnail .over-content {visibility:hidden;position:absolute;bottom:0;left:0;width:1px;height:1px;background:#000;font-weight:bold;font-style:normal;color:#fff;text-align:center;opacity:.6;filter:alpha(opacity=60)}
.thumbnail .over-content {_visibility:visible;_width:100%;_height:auto;_line-height:20px}
a:focus .over-content{visibility:visible;width:100%;height:auto}
</style>
<p>Total <?php echo $pages['total_page']?>/<?php echo $pages['page']?></p>

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

  <div class="col-xs-6 col-md-3">
    <a href="#" class="thumbnail">
      <img data-src="holder.js/100%x180" style="height: 180px; width: 100%;" alt="<?php echo $subject?>">
      <div class='over-content'>
aaaa

      </div>
    </a>
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