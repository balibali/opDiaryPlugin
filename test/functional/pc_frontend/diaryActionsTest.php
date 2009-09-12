<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opDiaryPluginTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->get('/diary')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'index')
  ->end()

  ->with('response')->begin()
    ->checkElement('h3', 'Recently Posted Diaries')
  ->end()
;
