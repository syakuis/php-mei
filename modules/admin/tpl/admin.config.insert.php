<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_ADMIN_']['MODULE_PATH']}/tpl/admin.header.php"; ?>
<?php
if ($object != NULL) {
  extract($object);
}
?>

<script type="text/javascript">//<![CDATA[

function save() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#module_title", params : "&filter=notnull&title=모듈명" }
      ,{ target : "#browser_title", params : "&filter=notnull&title=브라우저 제목" }
      ,{ target : "#options_default_module", params : "&filter=notnull&title=기본모듈선택" }
    ],
    param : '<?php echo _param_pick("module=&act=procAdminConfigInsert")?>' , 
    ask : 'save'
    //afterSend : function() { location.reload(); }
  });

}

function return_data(data) {
  jQuery('#options_default_module').val(data.module_orl);
  jQuery('#options_default_module_title').val(data.module_title);
}


//]]></script>


<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="module_orl" id="module_orl" value="<?php echo $module_orl?>" />
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

  <p class="lead">기본 설정</p>
  <div class="form-group">
    <label for="options_default_module" class="col-sm-2 control-label">기본 모듈 선택</label>
    <div class="col-sm-10">

      <div class="input-group">
      <input type="hidden" id="options_default_module" name="options_default_module" value="<?php echo $options_default_module?>" />
      <input type="text" class="form-control" id="options_default_module_title" name="options_default_module_title" value="<?php echo $options_default_module_title?>" />
      <span class="input-group-btn">
        <button class="btn btn btn-success" type="button" onclick="jQuery.module._open_search(return_data);">선택</button>
      </span>
      </div>
      <span class="help-block">인덱스 화면의 기본 모듈을 선택합니다.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="options_mobile_target" class="col-sm-2 control-label">모바일 대상</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_mobile_target" name="options_mobile_target" value="<?php echo $options_mobile_target?>" />
      <span class="help-block">모바일 대상 기기를 입력하시고 , (쉼표)로 구분하여 여러개를 입력할 수 있습니다.</span>
    </div>
  </div>

  <div class="tc">
  <button type="button" class="btn btn-info" onclick="save();">저장</button>
  </div>

</form>