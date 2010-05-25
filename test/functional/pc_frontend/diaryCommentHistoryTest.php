<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->info('Diary Comment History Test')
  ->get('/diary/comment/history')
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 22')
    ->checkElement('.pagerRelative .prev', 0)
    ->checkElement('.pagerRelative .next', 2)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 22 of 22')
    ->checkElement('.pagerRelative .prev', 2)
    ->checkElement('.pagerRelative .next', 0)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
    ->isParameter('page', 1)
  ->end()
;
