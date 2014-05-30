<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_LAYOUT_']['MODULE_PATH']}/tpl/admin.header.php"; ?>
<?php
$mod = 'insert';
$is_mobile = 'N';

if ($object != NULL) {
  $mod = 'update';
  extract($object);
}
?>

<script type="text/javascript">//<![CDATA[
var mod = "<?php echo $mod?>";

jQuery(function() {

  jQuery.ja.setValue("#form #layout","<?php echo $layout?>");
  jQuery.ja.setValue("#form #is_mobile","<?php echo $is_mobile?>");
  jQuery.ja.setValue("#form #menu_orl","<?php echo $menu_orl?>");

});


function save() {

  jQuery('#form').jaAction({
    filter : [
    { target : "#title", params : "&filter=notnull&title=제목" },
    { target : "#layout", params : "&filter=notnull&title=레이아웃" }
    ],
    param : '<?php echo _param_pick("module=&act=procLayoutAdminInsert")?>' , 
    ask : mod , 
    redirect : "/?<?php echo _param_pick("module=&act=dispLayoutAdminList")?>"
  });

}

//]]></script>

<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="layout_orl" id="layout_orl" value="<?php echo $layout_orl?>" />

  <p class="lead">레이아웃 설정</p>
  <div class="form-group">
    <label for="title" class="col-sm-2 control-label">제목</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="title" name="title" value="<?php echo $title?>" placeholder="레이아웃 제목을 입력하세요." />
    </div>
  </div>

  <div class="form-group">
    <label for="is_mobile1" class="col-sm-2 control-label">모바일 여부</label>
    <div class="col-sm-10">
      <div class="checkbox">
      <label><input type="checkbox" name="is_mobile" id="is_mobile" value="Y"> 사용함</label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="layout" class="col-sm-2 control-label">레이아웃</label>
    <div class="col-sm-10">

      <select class="form-control" name="layout" id="layout">
        <option value="">선택</option>
        <?php foreach($layout_list as $layout) { ?>
        <option value="<?php echo $layout?>"><?php echo $layout?></option>
        <?php } ?>
      </select>

    </div>
  </div>

  <div class="form-group">
    <label for="menu_orl" class="col-sm-2 control-label">메뉴</label>
    <div class="col-sm-10">

      <select class="form-control" name="menu_orl" id="menu_orl">
        <option value="">선택</option>
      </select>

    </div>
  </div>

  <div class="form-group">
    <label for="header_script" class="col-sm-2 control-label">헤더 스크립트</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="header_script" name="header_script" cols="80" rows="5"><?php echo $header_script?></textarea>
      <span class="help-block">HTML의 &lt;head>와 &lt;/head> 사이에 들어가는 코드를 직접 입력할 수 있습니다.&lt;script, &lt;style 또는 &lt;meta 태그 등을 이용하실 수 있습니다</span>
    </div>
  </div>
  
  <div class="tc">
  <a class="btn btn-default" href="./<?php echo _param_get('act=dispLayoutAdminList&layout_orl=','?')?>" role="button">목록</a>
  <button type="button" class="btn btn-info" onclick="save();">저장</button>
  </div>

</form>