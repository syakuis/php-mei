<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/admin.member.header.php"; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/admin.member.tab.php";?>
<?php
if ($object != NULL) {
  extract($object);
}
?>

<script type="text/javascript">//<![CDATA[

jQuery(function() {
  jQuery.ja.setValue("#form #layout_orl","<?php echo $layout_orl?>");
  jQuery.ja.setValue("#form #skin","<?php echo $skin?>");
});

function save() {

  jQuery('#form').jaAction({
    filter : [
       { target : "#module_title", params : "&filter=notnull&title=모듈명" }
    ],
    param : '<?php echo _param_pick("module=&act=procMemberAdminConfigInsert")?>' , 
    ask : 'save',
    afterSend : function() { location.reload(); }
  });

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

  <div class="form-group">
    <label for="layout_orl" class="col-sm-2 control-label">레이아웃</label>
    <div class="col-sm-10">

      <select class="form-control" name="layout_orl" id="layout_orl">
      <?php foreach(LayoutObject::getConfigList() as $layout) { ?>
      <option value="<?php echo $layout['layout_orl']?>"><?php echo $layout['title']?></option>
      <?php } ?>
      </select>
      <span class="help-block">사용자 페이지에 적용되는 레이아웃 입니다.</span>
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
  <button type="button" class="btn btn-primary" onclick="save();">저장</button>
  </div>

</form>