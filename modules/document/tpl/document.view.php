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


<form id="form" action="?" method="post">
<input type="hidden" id="document_orl" name="document_orl" value="<?php echo $document_orl?>" />
</form>

<div>
  <h2><?php echo $subject?>&nbsp;<small><?php echo $nickname?></small></h2>
  <ul class="list-inline">
    <li><?php echo $reg_datetime?></li>
    <li><span class="label label-default">조회 <?php echo $readed_count?></span></li>
    <li><span class="label label-default">추천 <?php echo $good_count?></span></li>
    <li><span class="label label-default">비추 <?php echo $bad_count?></span></li>
  </ul>
</div>

<div class="panel panel-default clearfix">
  <div class="panel-body">
    <?php echo $content?>
    <p>&nbsp;</p>
    <p class="text-center">
    <button type="button" class="btn btn-danger btn-lg" onclick="document_voted('good');"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;<?php echo $good_count?></button>
    <button type="button" class="btn btn-default btn-lg" onclick="document_voted('bad');"><span class="glyphicon glyphicon-thumbs-down"></span>&nbsp; <?php echo $bad_count?></button>
    </p>
    <p>
    <?php foreach($file_uploader_list as $rs) { ?>
    <a href="<?php echo $GV['PATH']['FILES_R_PATH'].$rs['path']?>"><span class="label label-default"><?php echo $rs['filename']?><?php echo $rs['size_unit']?></span></a>&nbsp;
    <?php } ?>
    </p>
  </div>
  <div class="panel-footer">
    <a class="btn btn-default" href="./<?php echo _param_get('act=&document_orl=&cpage=','?')?>" role="button">목록</a>
    <a class="btn btn-default" href="./<?php echo _param_pick('mid=&act=dispDocumentInsert','?')?>" role="button">쓰기</a>
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
    <a class="btn btn-info" href="./<?php echo _param_get('act=dispDocumentInsert','?')?>" role="button">수정</a>
    <button type="button" class="btn btn-danger" onclick="form_del();">삭제</button>
    <?php } ?>
  </div>
</div>

<?php if( $ModuleContext->getMod('options_user_docs_list') == 'Y' ) { ?>
<!-- 작성자 최근 글 -->
<div class="panel panel-default">
  <div class="panel-heading"><strong><?php echo $nickname?></strong> 님 최근 게시글</div>
  <ul class="list-group">
  <?php 
    foreach($user_list as $rs) { 
    $reg_datetime = _date('$1/$2/$3 $4:$5:$6',$rs['reg_datetime']); 
  ?>
  <li class="list-group-item"><a href="./<?php echo _param_get("act=dispDocumentView&document_orl={$rs['document_orl']}",'?')?>"><?php echo $rs['subject']?></a>&nbsp;<?php echo $reg_datetime?></li>
  <?php } ?>
  </ul>
</div>
<?php } ?>

<?php if( $ModuleContext->getMod('options_is_comment') == 'Y' ) { ?><div style="margin-top:20px;"><?php echo $comment_content?></div><?php } ?>

<?php if($ModuleContext->getMod('options_view_listoutput') == 'Y') { ?><div style="margin-top:20px;"><?php echo $list_content?></div><?php } ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>