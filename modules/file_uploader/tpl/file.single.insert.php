<?php if (!$start_swfupload) { ?>
<script type="text/javascript">
var swfu = [ ];
</script>

<!-- SWFUpload -->
<script type="text/javascript" src="<?php echo $_PATH_COMMON; ?>/jquery.syaku.file/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $_PATH_COMMON; ?>/jquery.syaku.file/SWFUpload/swfupload.queue.js"></script>
<!-- SWFUpload -->

<!-- Sayku Library -->
<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="<?php echo $_PATH_COMMON; ?>/jquery.syaku.file/syaku.file.css" />
<script type="text/javascript" src="<?php echo $_PATH_COMMON; ?>/jquery.syaku.file/syaku.file.js"></script>
<script type="text/javascript" src="<?php echo $_PATH_COMMON; ?>/jquery.syaku.file/syaku.file.handlers.js"></script>
<script type="text/javascript" src="<?php echo $_PATH_COMMON; ?>/jquery.syaku.file/syaku.<?php echo $_EDITOR_FM?>.handlers.js"></script>
<!-- Sayku Library -->
<?php } 
$start_swfupload = true;
?>
<div class='file_upload'>

  <div class='file_single_filed'>
    <div style="float:left;padding-right:5px;">

    <?php

    if ( $objFile->target_orl == 0 || empty($objFile->target_orl) ) {
      $objFile->_sid_delete($sid);
    }

    $item = "";
    $item_text = "";
    $rs = $objFile->_object();
    if ($rs != null) {
      $item = "{
        file_orl : '" . $rs['file_orl'] . "' , 
        file : '" . $rs['filename'] . "' , 
        re_file : '" . $rs['re_filename'] . "' , 
        folder : '" . $rs['folder'] . "' , 
        file_size : '" . $rs['size'] . "' ,
        extension : '" . $rs['extension'] . "' , 
        type : '" . $rs['type'] . "' 
      }";

      $file_size = $rs['size'];
      $file_size_unit = $objFile->_file_format($file_size);

      $item_text = $rs['filename'] . " ($file_size_unit)";
    }
    ?>

    <input type="hidden" id="file_orl<?php echo $objFile->seq?>" name="file_orl<?php echo $objFile->seq?>" value="<?php echo $item?>" />
    <input type="text" class="i_text w300" id="file<?php echo $objFile->seq?>" name="file<?php echo $objFile->seq?>" value="<?php echo $item_text?>" readonly="readonly" />
    </div>
    <div>
    <span id='swfu_button<?php echo $objFile->seq?>'></span>

    <span class="button medium"><button type="button" onclick="jQuery.syakuFileUpload.deleteSwfupload(swfu[<?php echo $objFile->seq?>],objEditor[<?php echo $objFile->seq?>]);">삭제</button></span>
    <?php if ($objFile->editor) { ?>
    <span class="button medium"><button type="button" onclick="jQuery.syakuFileUpload.editor_file_input(swfu[<?php echo $objFile->seq?>],objEditor[<?php echo $objFile->seq?>]);">삽입</button></span>
    <span class="button medium"><button type="button" onclick="jQuery.syakuFileUpload.editor_file_remove(swfu[<?php echo $objFile->seq?>],objEditor[<?php echo $objFile->seq?>]);">제거</button></span>
    <?php } ?>
    </div>
    <div class="clear"></div>
  </div>

  <div class="file_text">
    <?php
    if ( empty($objFile->opt_file_type) ) {
      $opt_file_type = "*.*";
      $opt_file_type_description = "모든 파일";
    } else {
      $opt_file_type = $objFile->opt_file_type;
      $opt_file_type_description = "사용자 지정 파일";
    }
    ?>
    <p>파일 제한 크기 : <?php if ($objFile->opt_file_once_size == 0) { ?>무제한<?php } else { ?><?php echo $objFile->opt_file_once_size?> KB<?php } ?> (<?php if ($objFile->opt_file_type == '') { ?>*.*<?php } else { ?><?php echo $objFile->opt_file_type?> <?php } ?>)</p>
  </div>

</div>

<script type="text/javascript">//<![CDATA[
  swfu[<?php echo $objFile->seq?>] = jQuery.syakuFileUpload.swfupload({
    ele_file : '#file<?php echo $objFile->seq?>',
    ele_file_orl : '#file_orl<?php echo $objFile->seq?>',
    ele_file_size : '#file_size_text<?php echo $objFile->seq?>',
    ele_preview : '#file_preview<?php echo $objFile->seq?>',
    file_size_limit : <?php echo $objFile->opt_file_once_size?> * 1024 , // KB -> Byte 변경
    file_types : '<?php echo $opt_file_type?>',
    file_types_description : '<?php echo $opt_file_type_description?>',
    file_upload_multi : false,
    file_upload_limit : 0, // 파일 첨부수
    file_upload_unlimited : <?php echo ($objFile->opt_file_limit > 0) ? "false" : "true"; ?>,

    <?php if ( !empty($objFile->upload_after_handler) ) { ?>
    upload_after_handler : <?php echo $objFile->upload_after_handler?>,
    <?php } ?>

    post_params: { 
      file_orl : '',
      target_orl : '<?php echo $objFile->target_orl?>', // 자료ID
      mid : '<?php echo $objFile->mid?>',
      sid : '<?php echo $objFile->sid?>',
      seq : '<?php echo $objFile->seq?>',
      user_id : '<?php echo $_SESSION['_SESS_USER_ID']?>',  // 시스템ID

      opt_file_upload_multi : "false",
      opt_file_size : "<?php echo $objFile->opt_file_size?>",
      opt_file_limit : <?php echo $objFile->opt_file_limit?>
    },
    button_placeholder_id : 'swfu_button<?php echo $objFile->seq?>'
  });
//]]></script>


<?php $objFile->close(); ?>