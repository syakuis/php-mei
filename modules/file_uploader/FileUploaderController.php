<?php
/*
 @class FileUploaderController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class FileUploaderController {

  function procFileUploaderInsert() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $M = $Context->getM();

    $FILE_DIR = $GV['PATH']['FILES_PATH'];
    $sid = $Context->getSid();

    $error = false;
    $message = '';
    $file_orl = '';
    $file = '';
    $re_file = '';
    $folder = "";
    $file_size = '';
    $extension = '';
    $type = '';

    $module_orl = _post('module_orl');
    $seq = _post('seq');
    $target_orl = (int)_post('target_orl','0');
    $file_upload_multi = _post('file_upload_multi');

    if (!isset($_FILES["file_upload"]) || !is_uploaded_file($_FILES["file_upload"]["tmp_name"]) || $_FILES["file_upload"]["error"] != 0) {
      $error = true;
      $message = 'ERROR:invalid upload';
    } else {

      $file = $_FILES["file_upload"]["name"];
      $file_size = $_FILES["file_upload"]["size"];
      $type = $_FILES["file_upload"]["type"];

      // 용량 단위 변경
      $options_file_size = $M['options_file_size'] * 1024;
      $options_file_limit = $M['options_file_limit'];

      // 멀티인 경우 파일 첨부수 체크 , 전체 파일 용량수 체크 , 기존파일 삭제
      $file_add_num = 1;
      if ($file_upload_multi == "true") {
        $data_file = FileUploaderDAO::getFileSizeSum($module_orl, $seq, $sid, $target_orl);
        $it_file_size = $data_file['size'] + $file_size;
        $it_file_limit = $data_file['limit'] + 1;

        if ( $options_file_size > 0 && $options_file_size < $it_file_size) {
          throw new Exception("총 업로드 제한 용량을 넘었습니다.");
        }
        
        // swfupload 에서 처리할 수 없어 파일첨부수 필터 구성
        if ( $options_file_limit > 0 && $options_file_limit < $it_file_limit) {
          throw new Exception("업로드 할 수 있는 파일 제한수를 넘었습니다.");
        }

        $file_add_num = $it_file_limit;
      }

      // 싱글인 경우 기존 파일 삭제
      if ( $file_upload_multi == "false" && $target_orl == 0 ) {
        FileUploaderObject::deleteFileSid($module_orl,$seq,$sid);
      }

      // 파일명 구현
      $extension = substr(strrchr($file, "."), 1);
      $filename = substr($file, 0, strlen($file) - strlen($extension) - 1);
      $re_filename = md5(date('siHdmY'));
      $re_file = $re_filename .'.' . $extension;
      if ( strpos($GV['_FILE_UPLOADER_']['FILE_TYPE_FILTER'],$extension) > -1 ) {
      if ( strpos($M['options_file_type'],$extension) === false ) {
          throw new Exception("업로드 할 수 없는 파일입니다.");
      }
      }

      $yyyy = date('Y');
      $mm = date('m');
      $dd = date('d');
      $folder_date = $yyyy.$mm.$dd;
      $folder = '/' . $module_orl . '/' . $folder_date;
      if ( !is_dir($FILE_DIR . '/' . $module_orl) ) {
        @mkdir($FILE_DIR . '/' . $module_orl,0777);
      }
      if ( !is_dir($FILE_DIR . $folder) ) {
        @mkdir($FILE_DIR . $folder,0777);
      }

      $cnt = 0;
      while( file_exists($FILE_DIR . $folder . '/' . $re_file) ) {
        $cnt++;
        $re_file = $re_filename."_".$cnt.".".$extension;
      }

      if ( !move_uploaded_file( $_FILES["file_upload"]["tmp_name"] , $FILE_DIR . $folder . '/' . $re_file ) ) {
        throw new Exception("업로드를 완료하지 못했습니다.");
      } else {

        $args = array();
        $args['module_orl'] = $module_orl;
        $args['seq'] = $seq;
        $args['target_orl'] = $target_orl;
        $args['num'] = $file_add_num;
        $args['sid'] = $sid;
        $args['member_orl'] = $_SESSION['_SESS_MEMBER_ORL'];
        $args['user_id'] = $_SESSION['_SESS_USER_ID'];
        $args['filename'] = $file;
        $args['re_filename'] = $re_file;
        $args['folder'] = $folder;
        $args['folder_date'] = $folder_date;
        $args['size'] = $file_size;
        $args['extension'] = $extension;
        $args['type'] = $type;

        try {
          $__Db->begin();
          $file_orl = FileUploaderDAO::insert($args);
          // document 모듈 파일수 업데이트
          if ( $target_orl != 0 ) DocumentObject::fileUploaderCrud($target_orl,FileUploaderDAO::getFileCount($module_orl, $seq, $sid, $target_orl));
          $__Db->commit();
        } catch(Exception $e) {
          $__Db->rollback();
          throw new Exception($e);
        }

      }

    }

    $ModuleContext->setMessage($message);
    $ModuleContext->setError($error);
    $ModuleContext->put('file_orl', $file_orl);
    $ModuleContext->put('filename', $file);
    $ModuleContext->put('re_file', $re_file);
    $ModuleContext->put('folder', $folder);
    $ModuleContext->put('file_size', $file_size);
    $ModuleContext->put('extension', $extension);
    $ModuleContext->put('type', $type);

    return $ModuleContext;
  }

  function procFileUploaderDelete() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $sid = $Context->getSid();

    $module_orl = _post('module_orl');
    $seq = _post('seq');
    $target_orl = (int)_post('target_orl', '0');
    $file_orl = _post('file_orl');

    try {
      $__Db->begin();
      FileUploaderObject::deleteFileOne($file_orl);
      $count = FileUploaderDAO::getFileCount($module_orl, $seq, $sid, $target_orl);
      if ( $target_orl != 0 ) DocumentObject::fileUploaderCrud($target_orl, $count);
      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

}

?>
