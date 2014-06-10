<?php

class TestInterceptor {

  function before() {
    $ValueStack = ValueStack::getInstance();
    $time_start = getmicrotime(); // 실행 시작시각 
    $ValueStack->put('test', 'time_start', $time_start);
  }

  function after() {
    $ValueStack = ValueStack::getInstance();
    $time_start = (float) $ValueStack->get('test','time_start');
    $time_end = getmicrotime(); // 실행 시작시각 
    $time = $time_end - $time_start; //실행시간 
    echo $time_start . '///';
    echo $time_end;
  }

}

?>