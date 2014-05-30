<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MESSAGE_']['MODULE_PATH']}/tpl/admin.header.php"; ?>
<?php
$mod = 'insert';

if ($object != NULL) {
  $mod = 'update';
  extract($object);
}
?>

<script type="text/javascript">//<![CDATA[

var mod = '<?php echo $mod;?>';
jQuery(function() {
  jQuery.ja.setValue("#form #skin","<?php echo $skin?>");
});


function save() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#module_title", params : "&filter=notnull&title=모듈명" }
      ,{ target : "#skin", params : "&filter=notnull&title=스킨" }
    ],
    param : '<?php echo _param_pick("module=&act=procMessageAdminConfigInsert")?>' , 
    ask : mod,
    afterSend : function() { location.reload(); }
  });

}

//]]></script>


<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="module_orl" id="module_orl" value="<?php echo $module_orl?>" />
  <p class="lead">메세지 설정</p>
  <div class="form-group">
    <label for="module_title" class="col-sm-2 control-label">모듈명</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="module_title" name="module_title" value="<?php echo $module_title?>" placeholder="모듈명을 입력하세요." />
    </div>
  </div>

  <div class="form-group">
    <label for="browser_title" class="col-sm-2 control-label">브라우저 제목</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="browser_title" name="browser_title" value="<?php echo $browser_title?>" placeholder="브라우저 제목을 입력하세요." />
    </div>
  </div>

  <div class="form-group">
    <label for="skin" class="col-sm-2 control-label">스킨</label>
    <div class="col-sm-10">

      <select class="form-control" name="skin" id="skin">
      <option value="0" selected="selected">선택</option>
      <?php foreach($skin_list as $skin) { ?>
      <option value="<?php echo $skin?>"><?php echo $skin?></option>
      <?php } ?>
      </select>

    </div>
  </div>

  <div class="tc">
  <button type="button" class="btn btn-info" onclick="save();">저장</button>
  </div>

</form>