<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.header.php"; ?>
<script type="text/javascript">

function _goto() {
  jQuery('.message').remove();
  jQuery('#form').jaAction({ 
    param : 'module=install&act=procInstallPrepare',
    ask_msg : '진행하시겠습니까?' ,

    setAjax : {
      success : function(xml) {
        var success = jQuery(xml).find('success').text();
        if (success == 'false') {
        var php = jQuery(xml).find('php').text();
        if (php == 'false') jQuery('#php_chk').append("<p class='message'>현재 PHP 버전에 설치할 수 없습니다.</p>");
        var mysql = jQuery(xml).find('mysql').text();
        if (mysql == 'false') jQuery('#mysql_chk').append("<p class='message'>현재 MySQL 버전에 설치할 수 없습니다.</p>");
        var grant = jQuery(xml).find('grant').text();
        if (grant == 'false') jQuery('#create_chk').append("<p class='message'>data 폴더 권한이 없습니다.</p>");
        var data_folder = jQuery(xml).find('data_folder').text();
        if (data_folder == 'false') jQuery('#create_chk').append("<p class='message'>data 폴더 생성을 실패했습니다.</p>");
        var files_folder = jQuery(xml).find('files_folder').text();
        if (files_folder == 'false') jQuery('#create_chk').append("<p class='message'>files 폴더 생성을 실패했습니다. 폴더 권한을 확인하세요.</p>");
        var cache_folder = jQuery(xml).find('cache_folder').text();
        if (cache_folder == 'false') jQuery('#create_chk').append("<p class='message'>cache 폴더 생성을 실패했습니다. 폴더 권한을 확인하세요.</p>");
        var config_folder = jQuery(xml).find('config_folder').text();
        if (config_folder == 'false') jQuery('#create_chk').append("<p class='message'>config 폴더 생성을 실패했습니다. 폴더 권한을 확인하세요.</p>");
        var session_folder = jQuery(xml).find('session_folder').text();
        if (session_folder == 'false') jQuery('#create_chk').append("<p class='message'>session 폴더 생성을 실패했습니다. 폴더 권한을 확인하세요.</p>");
        } else {
          location.href='./?module=install&act=dispInstallDbSetting';
        }
      }
    }

  });
}
</script>

<form id="form" method="post" action="?"></form>

<div class="page-header">
  <h1>설치준비</h1>
</div>

<div class="bs-callout bs-callout-danger">
<h4>PHP-MEI 설치 정보</h4>
<p>설치 버전 <code>1.0.0</code></p>
<p>설치 경로 <code><?php echo _ROOT_PATH_?></code></p>
</div>

<div class="bs-callout bs-callout-danger" id="php_chk">
<h4>PHP Version 5.3 이상을 권장합니다.</h4>
<p>현재 설치되어 있는 PHP Version 은 <code><?php echo phpversion();?></code> 입니다.</p>
</div>

<div class="bs-callout bs-callout-danger" id="mysql_chk">
<h4>MySQL Version 5.0 이상을 권장합니다.</h4>
<p>현재 설치되어 있는 MySQL Version 은 <code><?php echo mysql_get_client_info()?></code> 입니다.</p>
<p>데이터베이스 언어셋은 <code>UTF-8</code> 로 설정하세요. </p>
</div>

<div class="bs-callout bs-callout-danger" id="create_chk">
<h4>data 폴더 퍼미션을 757로 변경하세요.</h4>
<p>data 폴더 경로는 <code><?php echo $GV['PATH']['DATA_PATH']?></code> 입니다.</p>
</div>

<p class="text-right">
<p class="text-right"><button type="button" class="btn btn-success" onclick="_goto();"><span class="glyphicon glyphicon-share-alt"></span> 다음</button></p>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.footer.php"; ?>