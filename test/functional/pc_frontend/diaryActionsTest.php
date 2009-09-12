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

$test->info('Diary Pager Test')
  ->get('/diary/list')
  ->with('response')->begin()
    ->checkElement('.pagerRelative', true, array('count' => 2))
    ->checkElement('.pagerRelative .number', '1 - 20 of 22')
    ->checkElement('.pagerRelative .prev', false)
    ->checkElement('.pagerRelative .next', true)
  ->end()

  ->get('/diary/list', array('page' => 2))
  ->with('response')->begin()
    ->checkElement('.pagerRelative', true, array('count' => 2))
    ->checkElement('.pagerRelative .number', '21 - 22 of 22')
    ->checkElement('.pagerRelative .prev', true)
    ->checkElement('.pagerRelative .next', false)
  ->end()
;
