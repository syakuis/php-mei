<?php if (!defined("__SYAKU__")) exit; ?>
<div style="width:400px;margin:0 auto;">
<div class="panel panel-default">
  <div class="panel-body">Message</div>
  <div class="panel-footer">
  <p><?php echo $ModuleContext->getMessage()?></p>
  <p class="tr">
    <button type="button" class="btn btn-default" onclick="history.back();">돌아가기</button>
    <a class="btn btn-success" href="/<?php echo _RELATIVE_PATH_?>" role="button">홈페이지</a>
    <a class="btn btn-primary" href="./<?php echo _param_get('act=dispMemberLogin','?');?>" role="button">로그인</a>
  </p>
  </div>
</div>
</div>