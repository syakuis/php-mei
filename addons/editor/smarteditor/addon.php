<?php if (!defined("__SYAKU__")) exit; ?>
  <script type="text/javascript" src="<?php echo _ADDONS_R_PATH_?>/editor/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">

var objEditor = [ ];

var smarteditor_config = {
    oAppRef: objEditor,
    elPlaceHolder: "",
    sSkinURI: "<?php echo _ADDONS_R_PATH_?>/editor/smarteditor/SmartEditor2Skin.html",	
    htParams : {
      bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
      bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
      bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
      fOnBeforeUnload : function(){ }
    }, //boolean
    fOnAppLoad : function(){ },
    fCreator: "createSEditor2"
};
</script>

<?php
function _addon_editor($target,$seq="0",$config = "smarteditor_config") {
echo "nhn.husky.EZCreator.createInIFrame(

  jQuery.extend(true,$config , { 
    elPlaceHolder: '$target',
    fOnAppLoad : function(){
      objEditor[$seq] = objEditor.getById['$target'];
    }
  })

);

jQuery.jaAction.setDefaults({
  prepare : function() {
    objEditor[$seq].exec('UPDATE_CONTENTS_FIELD', []);
  }
});";
}
?>
