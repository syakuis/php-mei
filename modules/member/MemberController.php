<?php
/*
 @class MemberController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class MemberController {

  function procMemberLogin() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $user_id = _post('user_id');
    $password = _post('password');

    $rs = MemberDAO::selectOne($user_id, 'user_id');

    if ($rs) {
      $success = false;
      $member_orl = $rs['member_orl'];
      $temp_password = $rs['temp_password'];
      if ( $rs['status'] < 0 ) return $ModuleContext->resultError("접속할 수 없는 아이디입니다.");
      if ( $rs['password'] == md5($password) ) $success = true;

      if ( !empty($temp_password) && $temp_password == md5($password) ) {
        $success = true;
        // 임시암호를 비밀번호로 변경하고 임시암호 삭제
        MemberDAO::updateTempPassword($member_orl,$temp_password,NULL);
      }

      /* 세션 정보
      $_SESSION['_SESS_LOGIN_ORL'] = $login_orl;
      $_SESSION['_SESS_MEMBER_ORL'] = $user['member_orl'];
      $_SESSION['_SESS_USER_ID'] = $user['user_id'];
      $_SESSION['_SESS_USER_NAME'] = $user['user_name'];
      $_SESSION['_SESS_NICKNAME'] = $user['nickname'];
      $_SESSION['_SESS_USER_ADMIN'] = $user['is_admin'];
      */
      if ($success) {
        MemberObject::setSignIn($rs);
        MemberDAO::updateLogin($_SESSION['_SESS_MEMBER_ORL']);
      } else {
        return $ModuleContext->resultError("찾을 수 없는 아이디이거나 비밀번호가 틀렸습니다.");
      }

    } else {
      return $ModuleContext->resultError("찾을 수 없는 아이디이거나 비밀번호가 틀렸습니다.");
    }

    return $ModuleContext;
  }

  function procMemberLogout() {
    $ModuleContext = ModuleContext::getInstance();
    MemberObject::setSignOut();
    return $ModuleContext;
  }

  function procMemberUserIdSearch() {
    $ModuleContext = ModuleContext::getInstance();

    $user_name = _post('user_name');
    $email = _post('email');

    $user_id = MemberDAO::getSearchUserId($user_name,$email);

    if ($user_id == NULL) {
      $ModuleContext->setMessage('찾을 수 없습니다.');
      $ModuleContext->setError(TRUE);
    } else {
      $ModuleContext->setMessage("{$user_id} 입니다.");
      $ModuleContext->setError(FALSE);
    }
    return $ModuleContext;
  }

  function procMemberPasswordSearch() {
    $ModuleContext = ModuleContext::getInstance();

    $user_name = _post('user_name');
    $user_id = _post('user_id');
    $email = _post('email');

    $member_orl = MemberDAO::getSearchPassword($user_name,$user_id,$email);

    if ( empty($member_orl) ) {
      $ModuleContext->setMessage('찾을 수 없습니다.');
      $ModuleContext->setError(TRUE);
    } else {
      // 임시 비밀번호 생성
      $temp_password = _rand_string(8);
      MemberDAO::updateTempPassword($member_orl ,NULL, md5($temp_password));
      $ModuleContext->setMessage("{$temp_password} 입니다.");
      $ModuleContext->setError(FALSE);
    }

    return $ModuleContext;
  }

  function procMemberUserIdCheck() {
    $ModuleContext = ModuleContext::getInstance();

    $member_orl = _post('member_orl');
    $user_id = _post('user_id');

    if (!MemberDAO::isUniqueUserId($user_id,$member_orl)) {
      $ModuleContext->setMessage('사용할 수 없습니다.');
      $ModuleContext->setError(TRUE);
    } else {
      $ModuleContext->setMessage('사용할 수 있습니다.');
      $ModuleContext->setError(FALSE);
    }

    return $ModuleContext;
  }

  function procMemberNickNameCheck() {
    $ModuleContext = ModuleContext::getInstance();

    $member_orl = _post('member_orl');
    $nickname = _post('nickname');

    if (!MemberDAO::isUniqueNickname($nickname,$member_orl)) {
      $ModuleContext->setMessage('사용할 수 없습니다.');
      $ModuleContext->setError(TRUE);
    } else {
      $ModuleContext->setMessage('사용할 수 있습니다.');
      $ModuleContext->setError(FALSE);
    }

    return $ModuleContext;
  }

  function procMemberEmailCheck() {
    $ModuleContext = ModuleContext::getInstance();

    $member_orl = _post('member_orl');
    $email = _post('email');

    if (!MemberDAO::isUniqueEmail($email,$member_orl)) {
      $ModuleContext->setMessage('사용할 수 없습니다.');
      $ModuleContext->setError(TRUE);
    } else {
      $ModuleContext->setMessage('사용할 수 있습니다.');
      $ModuleContext->setError(FALSE);
    }

    return $ModuleContext;
  }

  // 탈퇴
  function procMemberOut() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $args = new stdClass;
    $args->member_orl = $_SESSION['_SESS_MEMBER_ORL'];
    $args->password = _post('password');
    $args->memo = _post('memo');
    $args->status = '-2';

    $rs = MemberDAO::selectOne($args->member_orl);
    if ( ($rs['password'] != md5($args->password) ) || !$rs) throw new Exception("비밀번호 일치하지 않습니다.");

    try {
      $__Db->begin();
      MemberOutDAO::insert($args);
      MemberDAO::updateStatus($args->member_orl,$args->status);
      MemberObject::getSignOut();
      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procMemberSignup() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    try {
      $user_id = _post('user_id');
      $user_name = _post('user_name');
      $nickname = _post('nickname');
      $email = _post('email');
      $password = _post('password');

      if (!MemberDAO::isUniqueUserId($user_id,$member_orl)) throw new Exception("사용할 수 없는 아이디입니다.");
      if (!MemberDAO::isUniqueNickname($nickname,$member_orl)) throw new Exception("사용할 수 없는 닉네임입니다.");
      if (!MemberDAO::isUniqueEmail($email,$member_orl)) throw new Exception("사용할 수 없는 이메일입니다.");

      $args = array();
      $args['user_id'] = $user_id;
      $args['user_name'] = $user_name;
      $args['nickname'] = $nickname;
      $args['email'] = $email;
      $args['sid'] = $GV['SID'];
      $args['password'] = md5($password);

      $__Db->begin();
      MemberDAO::insert($args);
      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }


  function procMemberUpdate() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    try {
      $member_orl = $_SESSION['_SESS_MEMBER_ORL'];
      $nickname = _post('nickname');
      $email = _post('email');
      $password = _post('password');

      if (!MemberDAO::isUniqueNickname($nickname,$member_orl)) throw new Exception("사용할 수 없는 닉네임입니다.");
      if (!MemberDAO::isUniqueEmail($email,$member_orl)) throw new Exception("사용할 수 없는 이메일입니다.");

      $args = array();
      $args['nickname'] = $nickname;
      $args['email'] = $email;
      if ( !empty($password) ) $args['password'] = md5($password);

      $__Db->begin();
      MemberDAO::update($args, $member_orl);
      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procMemberAdminInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    try {
      $member_orl = _post('member_orl');
      $user_id = _post('user_id');
      $user_name = _post('user_name');
      $nickname = _post('nickname');
      $email = _post('email');
      $password = _post('password');
      $is_admin = _post('is_admin','N');
      $status = _post('status','0');

      if (!MemberDAO::isUniqueUserId($user_id,$member_orl)) throw new Exception("사용할 수 없는 아이디입니다.");
      if (!MemberDAO::isUniqueNickname($nickname,$member_orl)) throw new Exception("사용할 수 없는 닉네임입니다.");
      if (!MemberDAO::isUniqueEmail($email,$member_orl)) throw new Exception("사용할 수 없는 이메일입니다.");

      $args = array();
      $args['nickname'] = $nickname;
      $args['email'] = $email;
      if ( !empty($password) ) $args['password'] = md5($password);
      $args['is_admin'] = $is_admin;
      $args['status'] = $status;

      $__Db->begin();
      if (empty($member_orl)) {
        $args['user_id'] = $user_id;
        $args['user_name'] = $user_name;
        MemberDAO::insert($args);
      } else {
        MemberDAO::update($args, $member_orl);
      }
      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procMemberAdminDelete() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();
    
    try {
      $member_orl = _post('member_orl');
      if ( empty($member_orl) ) throw new Exception("Null Point Exception");
      MemberDAO::del($member_orl);
      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

}

?>
