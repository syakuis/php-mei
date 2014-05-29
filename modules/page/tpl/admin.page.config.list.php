<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_PAGE_']['MODULE_PATH']}/tpl/admin.page.header.php"; ?>
<table class="table table-hover">
<colgroup>
<col width="160"><col width="115"><col><col><col width="60">
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

foreach($V['list'] as $rs) {
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
<a class="btn btn-primary btn-xs" href="./?module=page&mid=<?php echo $mid?>" target="_blank"role="button">열기</a>
<a class="btn btn-success btn-xs" href="./<?php echo _param_pick("mid=&module=&act=dispPageAdminConfigInsert&module_orl={$module_orl}",'?')?>" role="button">설정</a>
<button type="button" class="btn btn-danger btn-xs" onclick="">삭제</button>
</td>
<td><?php echo $mid?></td>
<td><?php echo $module_title?></td>
<td><?php echo $browser_title?></td>
<td><?php echo $reg_datetime ?></td>
</tr>
<?php } ?>
<?php if ($V['pages']['total_count'] == 0) { ?>
<tr>
	<td colspan="5">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>

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
      page_row : "<?php echo $V['pages']['page_row']?>"
    , page_link : "<?php echo $V['pages']['page_link']?>"
    , page : "<?php echo $V['pages']['page']?>"
    , total_count : "<?php echo $V['pages']['total_count']?>"
    });
  </script>

  </div>

  <div class="col-md-4 tr">
    <a class="btn btn-primary btn-sm mt20" href="./<?php echo _param_pick('module=&act=dispPageAdminConfigInsert','?')?>" role="button">추가</a>
  </div>

</div>