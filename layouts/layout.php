<?php if (!defined("__SYAKU__")) exit; ?>
<!DOCTYPE html>
<html lang="ko">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="PHP-MEI" name="Generator" />
  <meta content="Seok Kyun. Choi. (http://syaku.tistory.com)" name="Programmed" />
  <title><?php echo $Context->getBrowser_title()?></title>
  <!-- ³ª´®°íµñ -->
  <link rel="stylesheet" href="<?php echo _MEI_R_PATH_?>/commons/nanum-fonts/nanumgothic.css" />

  <link rel="stylesheet" href="<?php echo _MEI_R_PATH_?>/css/default.css" />

  <script src="<?php echo _MEI_R_PATH_?>/js/json2.js"></script>
  <script src="<?php echo _MEI_R_PATH_?>/js/xml2json.js"></script>
  <script src="<?php echo _MEI_R_PATH_?>/js/jquery-1.10.2.min.js"></script>
  <script src="<?php echo _MEI_R_PATH_?>/js/jquery-migrate-1.2.1.min.js"></script>

  <script src="<?php echo _MEI_R_PATH_?>/js/js-commons.js"></script>

  <link rel="stylesheet" href="<?php echo $GV['PATH']['COMMONS_R_PATH']?>/action/jquery.action.css" />
  <script src="<?php echo $GV['PATH']['COMMONS_R_PATH']?>/action/jquery.action.js"></script>
  <script src="<?php echo $GV['PATH']['COMMONS_R_PATH']?>/action/jquery.action-ko.js"></script>
  <script src="<?php echo $GV['PATH']['COMMONS_R_PATH']?>/jquery-pagenavigator/jquery.pagenavigator.js"></script>

  <script type="text/javascript">
    var _relative_path = '<?php echo _MEI_R_PATH_?>';
    var _common_path = '<?php echo $GV['PATH']['COMMONS_R_PATH']?>';
    var _files_path = '<?php echo $GV['PATH']['FILES_R_PATH']?>';
    var _modules_path = '<?php echo $GV['PATH']['MODULES_R_PATH']?>';
    jQuery.jaAction.setDefaults( { result : { display : 'alert' } });
  </script>

  <?php
  // JS & CSS È£Ãâ
  foreach ($GV['CSS'] as $css) {
    echo "<link rel='stylesheet' type='text/css' href='{$css}' />\n";
  }
  foreach ($GV['JS'] as $js) {
    echo "<script type='text/javascript' language='javascript' src='{$js}'></script>\n";
  }
  ?>
  
  <?php echo $Context->getLayout('header_script'); ?>

</head>
<body>
<?php echo $LAYOUT_CONTENT?>
</body>
</html>