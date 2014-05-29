<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.header.php"; ?>
<?php
if ( !empty($MOD['options_editor']) ) include_once $GV['PATH']['ADDONS_PATH'] . "/editor/" . $MOD['options_editor'] . "/addon.php";

$document_orl = _param('document_orl');
$mod = 'insert';
if ($object != NULL) {
  $mod = 'update';
  extract($object);
}

?>

<script type="text/javascript">
var mod = "<?php echo $mod?>";

jQuery(function() {
  jQuery.ja.setValue("#form input:checkbox[name=is_notice]","<?php echo $is_notice?>");
  jQuery.ja.setValue("#form input:checkbox[name=is_bold]","<?php echo $is_bold?>");
  jQuery.ja.setValue("#form #color","<?php echo $color?>");
  jQuery('#form #color').change();

  <?php if ( !empty($MOD['options_editor']) ) _addon_editor('content'); ?>
});

function form_save() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#subject", params : "&filter=notnull&title=제목" }
    ],
    ask : mod , 
    param : '<?php echo _param_pick("mid=&act=procDocumentInsert")?>',
    <?php if($mod == 'insert') { ?>
    redirect : './<?php echo _param_pick('mid=','?')?>'
    <?php } else { ?>
    redirect : './<?php echo _param_get('act=&document_orl=','?')?>'
    <?php } ?>
  });

}
</script>

<div class="sub_column_content">

<form action="?" method="post" id="form">
<input type="hidden" id="document_orl" name="document_orl" value="<?php echo $document_orl?>" />
<input type="hidden" id="content_text" name="content_text" value="" />
		<div class="form_table">
		<table border="1" cellspacing="0">
		<tbody>
		<tr>
		<th scope="row">제목</th>
		<td>
			<div class="item"><input type="text" title="제목" class="i_text w90p" id="subject" name="subject" value="<?php echo $subject?>" /></div>
		</td>
		</tr>
    <?php if($MOD['options_is_notice'] == 'Y' || $MOD['options_is_subject_style'] == 'Y') { ?>
    <tr>
      <th scope="row">기능</th>
      <td>
        <div class="item">
          <?php if($MOD['options_is_notice'] == 'Y' && $GRANT['GRANT_MANAGER']) { ?>
          <input type="checkbox" id="is_notice" value="Y" name="is_notice" class="i_check" />
          <label for="is_notice" class="i_label">공지</label>
          <?php } ?>
          <?php if($MOD['options_is_subject_style'] == 'Y') { ?>
          <input type="checkbox" value="Y" id="is_bold" name="is_bold" class="i_check" />
          <label for="is_bold" class="i_label">제목 굵게</label>
          <select class="i_select" onchange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor;" style="background-color:#N;" id="color" name="color">
          <option style="background-color:#FFFFFF;" value="">제목 색깔</option>
          <option style="background-color:#555555" value="555555">제목 색깔</option>
          <option style="background-color:#222288" value="222288">제목 색깔</option>
          <option style="background-color:#226622" value="226622">제목 색깔</option>
          <option style="background-color:#2266EE" value="2266EE">제목 색깔</option>
          <option style="background-color:#8866CC" value="8866CC">제목 색깔</option>
          <option style="background-color:#88AA66" value="88AA66">제목 색깔</option>
          <option style="background-color:#EE2222" value="EE2222">제목 색깔</option>
          <option style="background-color:#EE6622" value="EE6622">제목 색깔</option>
          <option style="background-color:#EEAA22" value="EEAA22">제목 색깔</option>
          <option style="background-color:#EEEE22" value="EEEE22">제목 색깔</option>
          </select>
          <?php } ?>
        </div>
      </td>
    </tr>
    <?php } ?>
		<tr>
		<td colspan="2">
			<div class="item"><textarea title="내용" style="height:<?php echo $MOD['options_input_height']?>px;" id="content" name="content"><?php echo $content?></textarea></div>
		</td>
		</tr>
    <?php if($MOD['options_is_file'] == 'Y') { ?>
    <tr>
    <td colspan="2">
        <?php echo $file_uploader_content; ?>
    </td>
    </tr>
    <?php } ?>
		</tbody>
		</table>
	</div>
</form>

</div>

<div style="margin-top:5px;">
<?php if ( ($mod == 'update' && $GRANT_MINE ) || $mod == 'insert' ) { ?>
<span class="button medium"><input type="button" onclick="form_save();" value="저장" /></span>
<?php } ?>
<span class="button medium"><a href="./<?php echo _param_get('act=&document_orl=','?')?>">목록</a></span>
</div>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>