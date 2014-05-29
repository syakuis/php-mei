<?php if (!defined("__SYAKU__")) exit; ?>

<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="<?php echo $GV['LAYOUT_R_PATH']?>/css/style.css" />
<script type="text/javascript">//<![CDATA[

function _data(data) {
  close();
  opener.jQuery.module._open_return(data);
}

//]]></script>

<div class="sub_column_content">

<table cellspacing="0" border="1" class="tbl_type">
<colgroup>
<col width="80"><col width="115"><col><col width="60">
</colgroup>
<thead>
<tr>
<th scope="col">기능</th>
<th scope="col">MID</th>
<th scope="col">모듈명</th>
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
	$header_content = $rs['header_content'];
	$footer_content = $rs['footer_content'];
	$reg_datetime = _date('$1/$2/$3',$rs['reg_datetime']); 
?>
<tr>
<td>
<a href="javascript:_data({ mid : '<?php echo $mid?>' , module_orl : '<?php echo $module_orl?>' , module_title : '<?php echo $module_title?>' });">선택</a>
</td>
<td><?php echo $mid?></td>
<td class="title"><?php echo $module_title?></td>
<td class="date"><?php echo $reg_datetime ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>