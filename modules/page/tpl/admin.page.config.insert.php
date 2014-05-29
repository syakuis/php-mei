<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_PAGE_']['MODULE_PATH']}/tpl/admin.page.header.php"; ?>
<?php include_once "{$GV['_PAGE_']['MODULE_PATH']}/tpl/admin.page.tab.php"; ?>
<?php
$module_orl = _param('module_orl');
$mod = 'insert';

if ($V['object'] != NULL) {
  $rs = $V['object'];
  $mod = 'update';
  $module_id = $rs['mid'];
  $module_title = $rs['module_title'];
  $browser_title = $rs['browser_title'];
  $skin = $rs['skin'];
  $layout_orl = $rs['layout_orl'];
  $header_content = $rs['header_content'];
  $footer_content = $rs['footer_content'];

}
?>

<script type="text/javascript">//<![CDATA[

jQuery(function() {
  jQuery.ja.setValue("#form #skin","<?php echo $skin?>");
  jQuery.ja.setValue("#form #layout_orl","<?php echo $layout_orl?>");
  jQuery.ja.setValue("#form #menu_orl","<?php echo $menu_orl?>");
});


function save() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#module_id", params : "&filter=user_id&filter=notnull&title=MID" },
      { target : "#module_title", params : "&filter=notnull&filter=notnull&title=모듈명" },
      { target : "#browser_title", params : "&filter=notnull&title=브라우저 제목" }
    ],
    param : '<?php echo _param_pick("module=&act=procPageAdminConfigInsert")?>' , 
    ask : 'save',
    afterSend : function() { location.reload(); }
  });

}

//]]></script>

<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="module_orl" id="module_orl" value="<?php echo $module_orl?>" />

  <p class="lead">모듈 설정</p>
  <div class="form-group">
    <label for="module_id" class="col-sm-2 control-label">MID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="module_id" name="module_id" value="<?php echo $module_id?>" />
      <span class="help-block">알파벳 소문자와 숫자 _ 를 사용하여 모듈명을 완성하세요.</span>
    </div>
  </div>

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
    <label for="layout_orl" class="col-sm-2 control-label">레이아웃</label>
    <div class="col-sm-10">

      <select class="form-control" name="layout_orl" id="layout_orl">
      <option value="0" selected="selected">선택</option>
      <?php foreach($V['layout_list'] as $layout) { ?>
      <option value="<?php echo $layout['layout_orl']?>"><?php echo $layout['title']?></option>
      <?php } ?>
      </select>

    </div>
  </div>

  <div class="form-group">
    <label for="skin" class="col-sm-2 control-label">스킨</label>
    <div class="col-sm-10">

      <select class="form-control" name="skin" id="skin">
      <option value="0" selected="selected">선택</option>
      <?php foreach($V['skin_list'] as $skin) { ?>
      <option value="<?php echo $skin?>"><?php echo $skin?></option>
      <?php } ?>
      </select>

    </div>
  </div>

  <p class="lead">기타 설정</p>

  <div class="form-group">
    <label for="header_content" class="col-sm-2 control-label">상단 내용</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="header_content" name="header_content" cols="80" rows="5"><?php echo $header_content?></textarea>
      <span class="help-block">해당 게시판 모듈의 상, 하단에 출력될 내용을 지정할 수 있습니다.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="footer_content" class="col-sm-2 control-label">하단 내용</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="footer_content" name="footer_content" cols="80" rows="5"><?php echo $footer_content?></textarea>
      <span class="help-block">해당 게시판 모듈의 상, 하단에 출력될 내용을 지정할 수 있습니다.</span>
    </div>
  </div>

  <div class="tc">
  <a class="btn btn-default" href="./<?php echo _param_get('act=dispPageAdminConfigList&module_orl=','?')?>" role="button">목록</a>
  <button type="button" class="btn btn-primary" onclick="save();">저장</button>
  </div>

</form>