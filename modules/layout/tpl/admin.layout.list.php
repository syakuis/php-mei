<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_LAYOUT_']['MODULE_PATH']}/tpl/admin.header.php"; ?>

<script type="text/javascript">

  // 삭제
  function _admin_del(layout_orl) {
    jQuery('#form').jaAction({
      formAttr : 'method=post',
      param : '<?php echo _param_pick("module=&act=procLayoutAdminDelete")?>&layout_orl=' + layout_orl , 
      ask : 'del' ,
      afterSend : function() { location.reload(); }
    });
  }
</script>

<form id="form">
<table class="table table-hover">
<colgroup>
<col width="100"><col width="130"><col><col width="80"><col width="100">
</colgroup>

<thead>
<tr>
<th scope="col">기능</th>
<th scope="col">레이아웃</th>
<th scope="col">제목</th>
<th scope="col">모바일</th>
<th scope="col">등록일</th>
</tr>
</thead>

<tbody>

<?php

foreach($list as $rs) {
	$layout_orl = $rs['layout_orl'];
	$menu_orl = $rs['menu_orl'];
	$layout = $rs['layout'];
	$title = $rs['title'];
	$header_script = $rs['header_script'];
	$extra_vars = $rs['extra_vars'];
	$is_mobile = $rs['is_mobile'];
	$reg_datetime = _date('$1/$2/$3',$rs['reg_datetime']); 
?>
<tr>
<td>
<a class="btn btn-default btn-xs" href="./<?php echo _param_pick("module=&act=dispLayoutAdminInsert&layout_orl={$layout_orl}",'?')?>" role="button"><span class="glyphicon glyphicon-cog"></span></a>
<button type="button" class="btn btn-default btn-xs" onclick="_admin_del('<?php echo $layout_orl?>');"><span class="glyphicon glyphicon-trash"></button></button>
</td>
<td><?php echo $layout?></td>
<td><?php echo $title?></td>
<td><?php echo $is_mobile?></td>
<td><?php echo $reg_datetime ?></td>
</tr>
<?php } ?>
<?php if ($pages['total_count'] == 0) { ?>
<tr>
	<td colspan="5">등록된 자료가 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
</form>

<div class="row">
  <div class="col-md-8">

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

  <div class="col-md-4 tr">
    <a class="btn btn-default btn-sm mt20" href="./<?php echo _param_pick('module=&act=dispLayoutAdminInsert','?')?>" role="button">추가</a>
  </div>

</div>
