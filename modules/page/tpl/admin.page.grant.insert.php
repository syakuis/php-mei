<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_PAGE_']['MODULE_PATH']}/tpl/admin.page.header.php"; ?>
<?php include_once "{$GV['_PAGE_']['MODULE_PATH']}/tpl/admin.page.tab.php"; ?>

<?php
$module_orl = _param('module_orl');

$grant = $V['object'];
?>


<script type="text/javascript">//<![CDATA[

jQuery(function() {
  jQuery.ja.setValue("#form #access_privilege","<?php echo $grant['access']?>");
  jQuery.ja.setValue("#form #list_privilege","<?php echo $grant['list']?>");
  jQuery.ja.setValue("#form #view_privilege","<?php echo $grant['view']?>");
  jQuery.ja.setValue("#form #write_privilege","<?php echo $grant['write']?>");
  jQuery.ja.setValue("#form #comment_privilege","<?php echo $grant['comment']?>");
  jQuery.ja.setValue("#form #manager_privilege","<?php echo $grant['manager']?>");
});

function save() {

  jQuery('#form').jaAction({
    param : '<?php echo _param_pick("module=&act=procPageAdminGrantInsert")?>' , 
    ask : 'save',
    afterSend : function() { location.reload(); }
  });
}

//]]></script>


<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="module_orl" id="module_orl" value="<?php echo $module_orl?>" />

  <p class="bg-info" style="padding:15px;">특정 권한의 대상을 모두 해제하면 로그인하지 않은 회원까지 권한을 가질 수 있습니다.</p>

  <div class="form-group">
    <label for="access_privilege" class="col-sm-2 control-label">접근</label>
    <div class="col-sm-10">
        <select class="form-control grant_selectbox" id="access_privilege" name="access_privilege">
          <option value="0" selected="selected">모든 사용자</option>
          <option value="-1">로그인 사용자</option>
          <option value="-2">가입한 사용자</option>
          <option value="-99">최고관리자</option>
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="list_privilege" class="col-sm-2 control-label">목록</label>
    <div class="col-sm-10">
        <select class="form-control grant_selectbox" id="list_privilege" name="list_privilege">
          <option value="0" selected="selected">모든 사용자</option>
          <option value="-1">로그인 사용자</option>
          <option value="-2">가입한 사용자</option>
          <option value="-99">최고관리자</option>
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="view_privilege" class="col-sm-2 control-label">열람</label>
    <div class="col-sm-10">
        <select class="form-control grant_selectbox" id="view_privilege" name="view_privilege">
          <option value="0" selected="selected">모든 사용자</option>
          <option value="-1">로그인 사용자</option>
          <option value="-2">가입한 사용자</option>
          <option value="-99">최고관리자</option>
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="write_privilege" class="col-sm-2 control-label">글작성</label>
    <div class="col-sm-10">
        <select class="form-control grant_selectbox" id="write_privilege" name="write_privilege">
          <option value="0" selected="selected">모든 사용자</option>
          <option value="-1">로그인 사용자</option>
          <option value="-2">가입한 사용자</option>
          <option value="-99">최고관리자</option>
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="comment_privilege" class="col-sm-2 control-label">댓글작성</label>
    <div class="col-sm-10">
        <select class="form-control grant_selectbox" id="comment_privilege" name="comment_privilege">
          <option value="0" selected="selected">모든 사용자</option>
          <option value="-1">로그인 사용자</option>
          <option value="-2">가입한 사용자</option>
          <option value="-99">최고관리자</option>
        </select>
    </div>
  </div>

  <div class="form-group">
    <label for="manager_privilege" class="col-sm-2 control-label">관리자</label>
    <div class="col-sm-10">
        <select class="form-control grant_selectbox" id="manager_privilege" name="manager_privilege">
          <option value="-99">최고관리자</option>
        </select>
    </div>
  </div>

  <div class="tc">
  <a class="btn btn-default" href="./<?php echo _param_get('act=dispPageAdminList&module_orl=','?')?>" role="button">목록</a>
  <button type="button" class="btn btn-primary" onclick="save();">저장</button>
  </div>

</form>