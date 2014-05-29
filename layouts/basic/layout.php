<?php if (!defined("__SYAKU__")) exit; ?>
<script src="<?php echo $GV['PATH']['ADDONS_R_PATH']?>/ui/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo $GV['PATH']['ADDONS_R_PATH']?>/ui/bootstrap/css/bootstrap.min.css">

<style>
body {
  padding-top: 50px;
  padding-bottom: 20px;
}
</style>

<div id="wrap">

  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Project name</a>
      </div>
      <div class="navbar-collapse collapse">
        <form class="navbar-form navbar-right" role="form">
          <div class="form-group">
            <input type="text" placeholder="Email" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" placeholder="Password" class="form-control">
          </div>
          <button type="submit" class="btn btn-success">Sign in</button>
        </form>
      </div><!--/.navbar-collapse -->
    </div>
  </div>


  <div class="container">
    <?php echo $MODULE_CONTENT?>
    <hr>
    <footer>
      <p>&copy; Company 2014</p>
    </footer>
  </div> <!-- /container -->
</div>