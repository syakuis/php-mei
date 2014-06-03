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

<form role="form" action="?" method="post" id="form">
<input type="hidden" id="document_orl" name="document_orl" value="<?php echo $document_orl?>" />
<input type="hidden" id="content_text" name="content_text" value="" />

  <div class="form-group">
    <input type="text" class="form-control" id="subject" name="subject" placeholder="제목을 입력력하세요." value="<?php echo $subject?>">
  </div>

  <?php if($MOD['options_is_notice'] == 'Y' || $MOD['options_is_subject_style'] == 'Y') { ?>
  <div class="form-group">

    <?php if($MOD['options_is_notice'] == 'Y' && $GRANT['GRANT_MANAGER']) { ?>
    <label class="checkbox-inline">
    <input type="checkbox" id="is_notice" value="Y" name="is_notice"> 공지글
    </label>
    <?php } ?>
    <?php if($MOD['options_is_subject_style'] == 'Y') { ?>
    <label class="checkbox-inline">
    <input type="checkbox" id="is_bold" value="Y" name="is_bold"> 제목 굵게
    </label>&nbsp;
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
  <?php } ?>

  <div class="form-group">
  <textarea class="form-control" style="height:<?php echo $MOD['options_input_height']?>px;" id="content" name="content"><?php echo $content?></textarea>
  </div>
  <?php if($MOD['options_is_file'] == 'Y') { ?>
  <div class="form-group"><?php echo $file_uploader_content; ?></div>
  <?php } ?>
</form>


  <div class="tc">
  <a class="btn btn-default" href="./<?php echo _param_get('act=dispDocumentList&document_orl=','?')?>" role="button">목록</a>
  <?php if ( ($mod == 'update' && $GRANT_MINE ) || $mod == 'insert' ) { ?>
  <button type="button" class="btn btn-info" onclick="form_save();">저장</button>
  <?php } ?>
  </div>

<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/document.footer.php"; ?>