<?php
/*
 @class FileUploaderObject

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class FileUploaderObject {
  
  //_download_data
  function getFileExists($rs) {
    global $GV;
    $data = array();
    if (!$rs) return $data;

    $folder = $rs['folder'];
    $re_filename = $rs['re_filename'];
    $size = $rs['size'];

    $path = $GV['PATH']['FILES_PATH'] . $folder . '/' . $re_filename;

    if ( file_exists($path) ) {
      $data = $rs;
      $data['size_unit'] = _file_format($size);
      $data['path'] = $folder . '/' . $re_filename;
    }

    return $data;
  }
  
  // _download_list
  function getFileExistsList($module_orl,$seq,$target_orl) {
    $list = array();
    $result = FileUploaderDAO::selectTargetOrl($module_orl, $seq, NULL,$target_orl);

    foreach($result as $rs) {
      $data = self::getFileExists($rs);
      array_push($list,$data);
    }

    return $list;
  }

  // _download_once
  function getFileExistsObject($module_orl,$seq,$target_orl) {
    $rs = FileUploaderDAO::selectOneTargetOrl($module_orl, $seq, NULL,$target_orl);
    $data = self::getFileExists($rs);
    return $data;
  }


  //_file_exists
  function getIsFileExists($module_orl,$seq,$target_orl) {
    global $GV;

    $ret= false;
    $result = FileUploaderDAO::selectTargetOrl($module_orl, $seq, NULL,$target_orl);
    foreach($result as $rs) {
      $folder = $rs['folder'];
      $re_filename = $rs['re_filename'];
      $path = $GV['PATH']['FILES_PATH'] . $folder . '/' . $re_filename;

      if ( file_exists($path) ) {
        $ret = true;
        break;
      }
    }

    return $ret;
  }


  //  _image_object
  function getImageFileList($module_orl,$seq,$target_orl) {

    $list = array();
    $result = FileUploaderDAO::selectTargetOrl($module_orl, $seq, NULL,$target_orl);

    foreach($result as $rs) {
      $extension = strtolower($rs['extension']);
      if ( preg_match('/' . $extension . '/','jpg;gif;png;bmp') ) {
        $data = self::getFileExists($rs);
        array_push($list,$data);
      }
    }
    return $list;
  }

  // _remove
  function deleteFile($module_orl,$seq,$target_orl) {
    global $GV;
    $result = FileUploaderDAO::selectTargetOrl($module_orl, $seq, NULL,$target_orl);
    foreach($result as $rs) {
      $folder = $rs['folder'];
      $filename = $rs['re_filename'];
      $path = $GV['PATH']['FILES_PATH'] . $folder . '/' . $filename;
      if ( file_exists($path) ) unlink($path);
    }

    FileUploaderDAO::deleteTargetOrl($module_orl, $seq, $target_orl);
  }

  // _sid_delete
  function deleteFileSid($module_orl,$seq,$sid) {
    global $GV;

    $result = FileUploaderDAO::selectTargetOrl($module_orl, $seq, $sid, $target_orl);
    foreach($result as $rs) {
      $folder = $rs['folder'];
      $filename = $rs['re_filename'];
      $path = $GV['PATH']['FILES_PATH'] . $folder . '/' . $filename;
      if ( file_exists($path) ) unlink($path);
    }

    FileUploaderDAO::deleteSid($module_orl, $seq, $sid);
  }

  // _delete_one
  function deleteFileOne($file_orl) {
    global $GV;
    $__Db = Db::getInstance();
    $file_orls = explode("|",$file_orl);

    foreach($file_orls as $file_orl) {
      $rs = FileUploaderDAO::selectOne($file_orl);
      if ($rs) {
        $folder = $rs['folder'];
        $filename = $rs['re_filename'];
        $file = $GV['PATH']['FILES_PATH'] . $folder . '/' . $filename;
        if ( file_exists($file) ) unlink($file);
        FileUploaderDAO::deleteOne($file_orl);
      }

    }

  }


}

?>
