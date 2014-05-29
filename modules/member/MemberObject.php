<?php

class MemberObject {


  function isSignin() {
    return !empty($_SESSION['_SESS_USER_ID']);
  }

  function isAdmin() {
    return ($_SESSION['_SESS_USER_ADMIN'] == 'Y');
  }

  function setSignIn($user) {
    self::setSignOut();
    $login_orl = LoginDAO::insert($user['member_orl']);
    $_SESSION['_SESS_LOGIN_ORL'] = $login_orl;
    $_SESSION['_SESS_MEMBER_ORL'] = $user['member_orl'];
    $_SESSION['_SESS_USER_ID'] = $user['user_id'];
    $_SESSION['_SESS_USER_NAME'] = $user['user_name'];
    $_SESSION['_SESS_NICKNAME'] = $user['nickname'];
    $_SESSION['_SESS_USER_ADMIN'] = $user['is_admin'];
  }

  function setSignOut() {
    session_unset();
  }
  

  function getPrivileges($privileges) {
    switch ($privileges) {

      case 0 : // 모든 사용자
        return true;
      break;

      case -1 : // 로그인 사용자
        if (!self::isSignin()) { return false; }
      break;

      case -99 : // 최고 관리자
        if (!self::isAdmin()) { return false; }
      break;

      default : 
        return true;
      break;
    }

    return true;
  }

  function getGrant($privileges) {
    $grant['login'] = self::isSignin();
    $grant['access'] = self::getPrivileges($privileges['access']);
    $grant['list'] = self::getPrivileges($privileges['list']);
    $grant['view'] = self::getPrivileges($privileges['view']);
    $grant['write'] = self::getPrivileges($privileges['write']);
    $grant['comment'] = self::getPrivileges($privileges['comment']);

    $grant['mine'] = $grant['write'];
    $grant['manager'] = false; // 사용안함
    $grant['admin'] = false;


    if (self::isAdmin()) {
      $grant['mine'] = true;
      $grant['manager'] = true;
      $grant['admin'] = true;
    }

    return $grant;
  }  

}

?>