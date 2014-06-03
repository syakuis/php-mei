<?php if (!defined("__SYAKU__")) exit; ?>
<script type="text/javascript">
var swfu_path = '<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>';
var swfu_files_path = '<?php echo $GV['PATH']['FILES_R_PATH']; ?>';
var swfu_upload_url = '/?mid=<?php echo $M['mid']?>&module=file_uploader&act=procFileUploaderInsert';
var swfu_delete_data = 'mid=<?php echo $M['mid']?>&module=file_uploader&act=procFileUploaderDelete&module_orl=<?php echo $module_orl?>&seq=<?php echo $seq?>&target_orl=<?php echo $target_orl?>';

var swfu = [ ];
</script>

<!-- SWFUpload -->
<script type="text/javascript" src="<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>/js/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>/js/SWFUpload/swfupload.queue.js"></script>
<!-- SWFUpload -->

<!-- Sayku Library -->
<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>/js/syaku.file.css" />
<script type="text/javascript" src="<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>/js/syaku.file.js"></script>
<script type="text/javascript" src="<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>/js/syaku.file.handlers.js"></script>
<script type="text/javascript" src="<?php echo $GV['_FILE_UPLOADER_']['MODULE_R_PATH']; ?>/js/syaku.<?php echo $M['options_editor']?>.handlers.js"></script>
<!-- Sayku Library -->