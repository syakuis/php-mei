<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/admin.install.header.php"; ?>


<script type="text/javascript">//<![CDATA[

function install(module) {

  jQuery('.form').jaAction({
    param : '<?php echo _param_pick("module=&act=procInstallAdminInsert")?>&install_module=' + module , 
    ask_msg : '설치하시겠습니까?' , 
    afterSend : function() { location.reload(); }
  });

}

function del(install_orl) {

  jQuery('.form').jaAction({
    param : '<?php echo _param_pick("module=&act=procInstallAdminDelete")?>&install_orl=' + install_orl , 
    ask_msg : '삭제하시겠습니까?' , 
    afterSend : function() { location.reload(); }
  });

}

//]]></script>

<div class="well">모듈 삭제는 설치 정보 데이터(install 테이블)만 제거됩니다. 필수 테이블 및 데이터는 직접 삭제하세요.</div>

<form class="form" method="post" action="?">
<table class="table table-hover">
<colgroup>
<col width="50"><col width="130"><col width="80"><col><col width="100">
</colgroup>

<thead>
<tr>
<th scope="col">기능</th>
<th scope="col">모듈</th>
<th scope="col">설치</th>
<th scope="col">설명</th>
<th scope="col">설치일</th>
</tr>
</thead>

<tbody>

<?php

foreach($list as $rs) {
	$install_orl = $rs['install_orl'];
	$module = $rs['module'];
	$status = $rs['status'];
	$reg_datetime = _date('$1/$2/$3',$rs['reg_datetime']); 
	$brief = $rs['brief'];
?>
<tr>
<td>
<?php if ($status != 'Y') { ?>
<button type="button" class="btn btn-default btn-xs" onclick="install('<?php echo $module?>');"><span class="glyphicon glyphicon-save"></button></button>
<?php } else { ?>
<button type="button" class="btn btn-default btn-xs" onclick="del('<?php echo $install_orl?>');"><span class="glyphicon glyphicon-trash"></button></button>
<?php } ?>
</td>
<td><?php echo $module?></td>
<td>
<?php if ($status != 'Y') { ?>
<span class="label label-danger">설치안됨</span>
<?php } else { ?>
<span class="label label-success">설치됨</span>
<?php } ?>
</td>
<td><?php echo $brief?></td>
<td><?php echo $reg_datetime ?></td>
</tr>
<?php } ?>
<?php if ( empty($list) ) { ?>
<tr>
	<td colspan="5">등록된 자료가 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
</form>