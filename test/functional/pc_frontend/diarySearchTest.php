<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opDiaryPluginTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->info('Search Test')
  ->get('/diary/list')
  ->with('response')->begin()
    ->checkElement('#diarySearchFormLine', true)
  ->end()
;

$keyword = 'tititi';
$test->info('Search Test')
  ->click('Search', array('keyword' => $keyword))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 51')
    ->checkElement('.pagerRelative .prev', 0)
    ->checkElement('.pagerRelative .next', 2)
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '21 - 40 of 51')
    ->checkElement('.pagerRelative .prev', 2)
    ->checkElement('.pagerRelative .next', 2)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('postion' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('postion' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()
;
