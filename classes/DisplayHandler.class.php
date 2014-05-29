<?php

class DisplayHandler {
  private $ModuleContext = NULL;
  private $Context = NULL;
  private $ValueStack = NULL;

  function DisplayHandler($ModuleContext) {
    $this->ModuleContext = $ModuleContext;
    $this->Context = Context::getInstance();
    $this->ValueStack = ValueStack::getInstance();
  }

  function getContent($is_basic_hidden = NULL, $is_layout_hidden = NULL) {
    $ModuleContext = $this->ModuleContext;
    $Context = $this->Context;
    $GV = $Context->getGV();
    $LAYOUT = $Context->getLayout();

    if ( is_null($is_basic_hidden) ) $is_basic_hidden = TRUE;

    if ( is_null($is_layout_hidden) ) $is_layout_hidden = TRUE;
    if ( !is_null($Context->getLayoutHidden()) ) $is_layout_hidden = $Context->getLayoutHidden();

    $content = array();
    $result = '';

    // 출력
    switch($ModuleContext->getActConfig('result')) {
      case 'html' :
      default :
        if ( $ModuleContext->getError() ) {

          $_ModuleContext = ModuleHandler::getModule('module', 'message');
          $_ModuleContext->setMessage($ModuleContext->getMessage());
          $DisplayHandler = new DisplayHandler($_ModuleContext);
          $result = $DisplayHandler->getContent();
          $content['MODULE_CONTENT'] = $result;

        } else {
        // 모듈 스킨
          $SKIN_INFO = $ModuleContext->getSkinInfo();
          $template = $SKIN_INFO['SKIN_FILE'];
          $result = $this->getHtml($template);
          $content['MODULE_CONTENT'] = $result;
        }

        // 레이아웃
        if ( !$is_layout_hidden ) {
          if ( $LAYOUT ) {
          $LAYOUT_PATH = $Context->getLayoutPath();
          $template = "{$LAYOUT_PATH['LAYOUT_PATH']}/{$LAYOUT_PATH['LAYOUT_FILE']}";
          $result = $this->getHtml($template, $content);
          }
        }
        $content['LAYOUT_CONTENT'] = $result;

        // 기본 레이아웃
        if ( !$is_basic_hidden ) {
        $template = $GV['PATH']['LAYOUTS_PATH'] . "/layout.php";
        $result = $this->getHtml($template, $content);
        $content['BASIC_CONTENT'] = $result;
        }

      break;
      case 'xml' :
        header("Content-Type: text/xml; charset=UTF-8");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $result = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<data>\n";
        $result .= sprintf("<error>%s</error>\n", _strval($ModuleContext->getError()));
        $result .= sprintf("<message>%s</message>\n", str_replace(array('<', '>', '&'), array('&lt;', '&gt;', '&amp;'), $ModuleContext->getMessage()));
        $result .= $this->makeXml($ModuleContext->get());
        $result .= "</data>";
      break;
    }

    return $result;
  }

  private function getHtml($template, $layout_content = array()) {
    $Context = $this->Context;
    $GV = $Context->getGV();
    $M = $Context->getM();
    $GRANT = $Context->getGrant();
    $ModuleContext = $this->ModuleContext;
    $MOD = $ModuleContext->getMod();
    $ValueStack = $this->ValueStack;

    if ( !is_file($template) ) throw new Exception("[getHtml] {$template} :: The file is not.");
    if ( !file_exists($template) ) throw new Exception("[getHtml] {$template} :: Not found file.");

    ob_start();
    @extract($layout_content);
    unset($layout_content);
    @extract($ModuleContext->get());
    include $template;
    $result = ob_get_contents();
    ob_end_clean();

    return $result;
  }

  private function makeXml($object = array()) {
    if(!count($object)) return;
    $document = '';

    foreach($object as $key => $val) {
      if(is_numeric($key))
      {
        $key = 'item';
      }

      if(is_string($val))
      {
        $document .= sprintf('<%s>%s</%s>%s', $key, htmlspecialchars($val) , $key, "\n");
      }
      else if(is_bool($val) || is_numeric($val))
      {
        $document .= sprintf('<%s>%s</%s>%s', $key, _strval($val), $key, "\n");
      }
      else if(!is_array($val) && !is_object($val))
      {
        $document .= sprintf('<%s>%s</%s>%s', $key, $val, $key, "\n");
      }
      else
      {
        $document .= sprintf('<%s>%s%s</%s>%s', $key, "\n", $this->makeXml($val), $key, "\n");
      }
    }

    return $document;
  }

}

?>