<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());
$test->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->get('/diary/1')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'show')
    ->isParameter('id', 1)
  ->end()

  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;
