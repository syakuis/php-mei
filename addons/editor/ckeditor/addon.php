<?php if (!defined("__SYAKU__")) exit; ?>
<script src="<?php echo $GV['PATH']['ADDONS_R_PATH']?>/editor/ckeditor/ckeditor.js"></script>

<script type="text/javascript">

var MEIeditor = [ ];
var objEditor = [ ];

var ckeditor_config = {
  resize_enabled : false,
  enterMode : CKEDITOR.ENTER_BR , 
  shiftEnterMode : CKEDITOR.ENTER_P , 
  toolbarCanCollapse : true , 
  extraPlugins : "tableresize" , 
  removePlugins : "elementspath",

  toolbar : [
    [ 'Source', '-' , 'NewPage', 'Preview' ],
    [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ],
    [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
    [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
    '/',
    [ 'Styles', 'Format', 'Font', 'FontSize' ],
    [ 'TextColor', 'BGColor' ],
    [ 'Image', 'Flash', 'Table' , 'SpecialChar' , 'Link', 'Unlink']
    
  ] 

};

function ja_ckeditor(obj) {

  jQuery.jaAction.setDefaults({
    
    prepare : function() {
      var cnt = obj.length;
      for (var i = 0; i < cnt; i++) {
        obj[i].updateElement();
      }
    }

  });

}
</script>

<?php
function _addon_editor($target,$seq="0",$config = "ckeditor_config") {

  echo "
  MEIeditor[{$seq}] = CKEDITOR.replace('{$target}' , {$config} );
  objEditor[{$seq}] = CKEDITOR.instances.{$target};
  ja_ckeditor(MEIeditor);
  ";

}
?>
