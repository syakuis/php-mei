<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once $GV['PATH']['ADDONS_PATH'] . "/ui/bootstrap/addon.php"; ?>
<link href="./layouts/basic/css/jumbotron-narrow.css" rel="stylesheet">

<div class="container">
  <div class="header">
    <ul class="nav nav-pills pull-right">
      <li><a href="./">Home</a></li>
      <?php if ($GRANT['GRANT_LOGIN']) { ?>
      <li><a href="javascript:jQuery.member.logout();">Logout</a></li>
      <?php } else { ?>
      <li><a href="./?act=dispMemberLogin">Login</a></li>
      <?php } ?>
      <?php if ($GRANT['GRANT_ADMIN']) { ?>
      <li><a href="./?module=admin">Admin</a></li>
      <?php } ?>
    </ul>
    <h3 class="text-muted"><?php echo $LAYOUT['options_title']?></h3>
  </div>

  <div style="margin-bottom:40px;"><?php echo $MODULE_CONTENT?></div>

  <div class="footer">
    <p>&copy; 2014 <a href="http://syakuis.github.io/php-mei" target="_blank">PHP-MEI</a>.</p>
  </div>

</div> <!-- /container -->