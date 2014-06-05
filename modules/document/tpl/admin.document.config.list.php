<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/admin.document.header.php"; ?>

<table class="table table-hover">
<colgroup>
<col width="110"><col width="115"><col><col><col width="60">
</colgroup>
<thead>
<tr>
<th scope="col">기능</th>
<th scope="col">MID</th>
<th scope="col">모듈명</th>
<th scope="col">브라우저 제목</th>
<th scope="col">등록일</th>
</tr>
</thead>
<tbody>

<?php
foreach($list as $rs) {
	$module_orl = $rs['module_orl'];
	$module = $rs['module'];
	$mid = $rs['mid'];
	$module_title = $rs['module_title'];
	$browser_title = $rs['browser_title'];
	$header_content = $rs['header_content'];
	$footer_content = $rs['footer_content'];
	$reg_datetime = _date('$1/$2/$3',$rs['reg_datetime']); 
?>
<tr>
<td>
<a class="btn btn-default btn-xs" href="./?mid=<?php echo $mid?>" target="_blank"role="button"><span class="glyphicon glyphicon-file"></span></a>
<a class="btn btn-default btn-xs" href="./<?php echo _param_pick("module=&act=dispDocumentAdminConfigInsert&module_orl={$module_orl}",'?')?>" role="button"><span class="glyphicon glyphicon-cog"></span></a>
<button type="button" class="btn btn-default btn-xs" onclick=""><span class="glyphicon glyphicon-trash"></span></button>
</td>
<td><?php echo $mid?></td>
<td><?php echo $module_title?></td>
<td><?php echo $browser_title?></td>
<td><?php echo $reg_datetime ?></td>
</tr>
<?php } ?>
<?php if ($pages['total_count'] == 0) { ?>
<tr>
	<td colspan="5">등록된 모듈이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>

<div class="clearfix">
  <div class="pull-left">

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

  <div class="pull-right">
    <a class="btn btn-default btn-sm mt20" href="./<?php echo _param_pick('module=&act=dispDocumentAdminConfigInsert','?')?>" role="button">추가</a>
  </div>

</div>