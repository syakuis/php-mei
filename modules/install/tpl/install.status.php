<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.header.php"; ?>


<script type="text/javascript">

function _reload() {
  location.reload();
}

jQuery(function() {

function _goto() {
  jQuery('#form').jaAction({ 
    param : 'module=install&act=procInstallCreateTable',
    setAjax : {
      success : function(xml) {
        var error = $.ja.defString($(xml).find('error').text(),$.jaAction.result.error);
        var action = $.ja.defString($(xml).find('action').text(),$.jaAction.result.action);
        var source = $.ja.defString($(xml).find('source').text(),$.jaAction.result.source);
        var message = $.ja.defString($(xml).find('message').text(),$.jaAction.result.message);
        if (error == 'false') {
          jQuery('#create_table_success').text('테이블 생성이 완료되었습니다.');
          _goto2();
        } else {
          jQuery('#btn_next').hide();
          jQuery('#btn_reload').show();
          jQuery('#create_table_success').text('테이블 생성이 실패되었습니다.');
          jQuery('#create_table').append('<p>' + message + '</p>');
        }
      }
    }

  });
}

function _goto2() {
  jQuery('#form').jaAction({ 
    param : 'module=install&act=procInstallModule',
    setAjax : {
      success : function(xml) {
        var error = $.ja.defString($(xml).find('error').text(),$.jaAction.result.error);
        var action = $.ja.defString($(xml).find('action').text(),$.jaAction.result.action);
        var source = $.ja.defString($(xml).find('source').text(),$.jaAction.result.source);
        var message = $.ja.defString($(xml).find('message').text(),$.jaAction.result.message);
        if (error == 'false') {
          jQuery('#insert_data_success').text('모튤설치가 완료되었습니다.');
        } else {
          jQuery('#insert_data_success').text('모듈설치가 실패되었습니다.');
          jQuery('#insert_data').append('<p>' + message + '</p>');
        }
      }
    }
  });
}

_goto();
});
</script>


<form id="form" method="post" action="?">
</form>

<div class="page-header">
  <h1>설치</h1>
</div>

<div class="bs-callout bs-callout-danger" id="create_table">
<h4>테이블 생성</h4>
<p id="create_table_success">테이블 생성 진행중....</p>
</div>

<div class="bs-callout bs-callout-danger" id="insert_data">
<h4>데이터 저장</h4>
<p id="insert_data_success">데이터 저장 진행중....</p>
</div>

<div class="bs-callout bs-callout-danger">
<h4>정리</h4>
</div>


<p class="text-right">
<a class="btn btn-success" href="./?module=install&act=dispInstallAdminInsert" role="button"  id="btn_next"><span class="glyphicon glyphicon-share-alt"></span> 다음</a>
<button type="button" class="btn btn-success" onclick="_reload();" id="btn_reload" style="display:none;"><span class="glyphicon glyphicon-share-alt"></span> 새로고침</button>
</p>

<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.footer.php"; ?>