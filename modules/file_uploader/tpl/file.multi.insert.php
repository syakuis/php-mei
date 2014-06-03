<?php if (!defined("__SYAKU__")) exit; ?>
<?php
include_once $GV['_FILE_UPLOADER_']['MODULE_PATH'] . '/file_upload.lib.php';
?>
<div class='file_upload' style='padding-bottom:5px;'>
  <div class='file_head'>
    <span id='swfu_button<?php echo $seq?>'></span>

    <span class="button medium"><button type="button" onclick="jQuery.syakuFileUpload.deleteSwfupload(swfu[<?php echo $seq?>],objEditor[<?php echo $seq?>]);">삭제</button></span>
    <?php if ($file_upload_multi == 'true') { ?>
    <span class="button medium"><button type="button" onclick="jQuery.syakuFileUpload.editor_file_input(swfu[<?php echo $seq?>],objEditor[<?php echo $seq?>]);">선택삽입</button></span>
    <span class="button medium"><button type="button" onclick="jQuery.syakuFileUpload.editor_file_remove(swfu[<?php echo $seq?>],objEditor[<?php echo $seq?>]);">선택모두제거</button></span>
    <?php } ?>
  </div>
  <div class='file_content'>
    <div class='file_preview' id='file_preview<?php echo $seq?>'></div>
    <div class='file_field'>
      <select class='file_view' id='file<?php echo $seq?>' name='file<?php echo $seq?>' multiple='multiple' onclick='jQuery.syakuFileUpload.preview(swfu[<?php echo $seq?>]);'>

      <?php
      $file_count = count($V['list']);
      echo $file_count;
      foreach($list as $rs) {
        $file_size = $rs['size'];
        $file_size_unit = _file_format($file_size);
        $total_size = $total_size + $file_size;
      ?>
      <option value="{
      file_orl : '<?php echo $rs['file_orl']?>' , 
      file : '<?php echo $rs['filename']?>' , 
      re_file : '<?php echo $rs['re_filename']?>' , 
      folder : '<?php echo $rs['folder']?>' , 
      file_size : '<?php echo $rs['size']?>' , 
      extension : '<?php echo $rs['extension']?>' , 
      type : '<?php echo $rs['type']?>'
      }"><?php echo $rs['filename']?> (<?php echo $file_size_unit?>)</option>
      <?php } ?>
      </select>
    </div>
    
    <div class='file_text'>
      <?php
      if ( empty($M['options_file_type']) ) {
        $options_file_type = "*.*";
        $options_file_type_description = "모든 파일";
      } else {
        $options_file_type = $M['options_file_type'];
        $options_file_type_description = "사용자 지정 파일";
      }
      ?>
      <p>총 용량 : <span id='file_size_text<?php echo $seq?>'><?php echo _file_format($total_size)?></span> / <?php if ($M['options_file_size'] == 0) { ?>무제한<?php } else { ?><?php echo $M['options_file_size']?> KB<?php } ?></p>
      <p>개당 용량 : <?php echo $M['options_file_once_size']?> KB</p>
      <p>파일 형식 : <?php echo $options_file_type?></p>
      <p>파일 제한 수 : <?php if ($M['options_file_limit'] == 0) { ?>무제한<?php } else { ?><?php echo $M['options_file_limit']?> <?php } ?></p>
    </div>

    <div class="clear"></div>
  </div>
</div>
<?php
$file_limits = $M['options_file_limit'];

if ($file_count > 0 && $file_limits > 0) {
  $file_limits = $file_limits - $file_count;
}
?>

<script type="text/javascript">//<![CDATA[
  swfu[<?php echo $seq?>] = jQuery.syakuFileUpload.swfupload({
    ele_file : '#file<?php echo $seq?>',
    ele_file_orl : '#file_orl<?php echo $seq?>',
    ele_file_size : '#file_size_text<?php echo $seq?>',
    ele_preview : '#file_preview<?php echo $seq?>',
    file_size_limit : <?php echo $M['options_file_once_size']?> , // KB
    file_types : '<?php echo $options_file_type?>',
    file_types_description : '<?php echo $options_file_type_description?>',
    file_upload_multi : true,
    file_upload_limit : <?php echo $file_limits?>, // 파일 첨부수
    file_upload_unlimited : <?php echo ($M['options_file_limit'] > 0) ? "false" : "true"; ?>,

    <?php if ( !empty($upload_after_handler) ) { ?>
    upload_after_handler : <?php echo $upload_after_handler; ?>,
    <?php } ?>

    post_params: { 
      file_upload_multi : true,
      file_orl : '',
      target_orl : '<?php echo $target_orl?>', // 자료ID
      module_orl : '<?php echo $module_orl?>',
      PHPSESSID : '<?php echo $sid?>',
      seq : '<?php echo $seq?>',
      member_orl : '<?php echo $_SESSION['_SESS_MEMBER_ORL']?>',
      user_id : '<?php echo $_SESSION['_SESS_USER_ID']?>' // 시스템ID
    },
    button_placeholder_id : 'swfu_button<?php echo $seq?>'
    , debug : false
  });
//]]></script>