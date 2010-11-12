<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('html1@example.com', 'password');

// CSRF
$test
  ->info('/diary/create - CSRF')
  ->post('/diary/create')
  ->checkCSRF()

  ->info('/diary/delete - CSRF')
  ->post('/diary/delete/1055')
  ->checkCSRF()

  ->info('/diary/update - CSRF')
  ->post('/diary/update/1055')
  ->checkCSRF()

  ->info('/diaryComment/create - CSRF')
  ->post('/diary/1055/comment/create')
  ->checkCSRF()

  ->info('/diaryComment/delete - CSRF')
  ->post('/diary/comment/delete/1055')
  ->checkCSRF()

;
