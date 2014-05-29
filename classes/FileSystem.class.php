<?php
/*
 @class FileSystem

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

class FileSystem {

  function getRealPath($source) {
    $temp = explode('/', $source);
    if($temp[0] == '.') $source = _MEI_PATH_ . substr($source, 2);
    return $source;
  }

  public static function writeFile($filename, $buffer, $chmod = 0777, $lock = false) {

    try {
      $filename = self::getRealPath($filename);

      $handle = fopen($filename, 'w');

      if ($lock) {
        flock($handle, LOCK_EX);
        if (!$handle) throw new Exception("파일에 락이 걸려있습니다.");
      }

      if ( fwrite($handle,$buffer,strlen($buffer)) === FALSE ) throw new Exception("파일 생성에 실패하였습니다.");
      if ($lock) flock($handle, LOCK_UN);
      fclose($handle);
      chmod($filename, $chmod);

      return TRUE;
    } catch(Exception $e) {
      return FALSE;
    }

  }

	public static function getReadFile($filename) {
      $filename = self::getRealPath($filename);

		if(!file_exists($filename)) return NULL;

		$filesize = filesize($filename);
		if($filesize < 1) return NULL;
		return file_get_contents($filename);
	}

  
  function getDirFiles($dir) {
    $return = array();
    if (is_dir($dir)) {

      if ($open = opendir($dir)) {
        while ( ($file = readdir($open) ) !== false) {
          if($file == "." || $file == "..") continue;
          array_push($return, $file);
        }

        closedir($open);
      }
    }

    return $return;
  }


}
?>