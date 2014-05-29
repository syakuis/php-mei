<?php
/*
 @class LayoutInstall

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class layoutInstall {

  function moduleInstall() {
    global $GV;
    $__Db = Db::getInstance();

    // 모듈 설치
    $args = array();
    $args['module'] = $GV['_LAYOUT_']['MODULE'];
    $args['module_title'] = $GV['_LAYOUT_']['TITLE'];
    $args['browser_title'] = $GV['_LAYOUT_']['TITLE'];
    $args['locking'] = 'Y';
    ModuleObject::insertInstall($GV['_LAYOUT_'], $args, $GV['_LAYOUT_']['OPTIONS']);

    // 레이아웃 추가
    $args = new stdClass();
    $args->layout_orl = 1;
    $args->menu_orl = 0;
    $args->layout = 'admin';
    $args->title = '관리자';
    $args->is_mobile = 'N';
    $args->header_script = '<script src="./addons/ui/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./addons/ui/bootstrap/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="./addons/ui/bootstrap/css/bootstrap-theme.min.css">-->
    <!--<link href="./layouts/admin/themes/bootswatch.yeti.css" rel="stylesheet">-->
    <link href="./layouts/admin/css/offcanvas.css" rel="stylesheet">
    <link href="./layouts/admin/css/style.css" rel="stylesheet">
    <script src="./layouts/admin/js/offcanvas.js"></script>
    <script src="./commons/jquery-bootstrap/jquery.bootstrap.js"></script>';
    $args->reg_datetime = _date();

    $rs = LayoutDAO::selectOnce($args->layout_orl);
    if (!$rs) $__Db->queryForInsert('layout',$args);

    return true;
  }

}

?>
