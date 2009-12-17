<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());

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
$test->info('Search Test: '.$keyword)
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
    ->checkElement('.partsHeading h3', 'Search Results')
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
    ->checkElement('.partsHeading h3', 'Search Results')
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()
;

$keyword = '日本語';
$test->info('Search Test: '.$keyword)
  ->click('Search', array('keyword' => $keyword))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 2)
    ->checkElement('.pagerRelative .number', '1 - 20 of 21')
    ->checkElement('.pagerRelative .prev', 0)
    ->checkElement('.pagerRelative .next', 2)
    ->checkElement('.partsHeading h3', 'Search Results')
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
    ->checkElement('.pagerRelative .number', '21 - 21 of 21')
    ->checkElement('.pagerRelative .prev', 2)
    ->checkElement('.pagerRelative .next', 0)
    ->checkElement('.partsHeading h3', 'Search Results')
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()

  ->click('Next', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 2)
  ->end()

  ->click('Previous', array(), array('position' => 2))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()
;

$keyword = 'NoMatchingWord';
$test->info('Search Test: '.$keyword)
  ->click('Search', array('keyword' => $keyword))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
  ->end()
  ->with('response')->begin()
    ->checkElement('.pagerRelative', 0)
    ->checkElement('.partsHeading h3', 'Search Results')
    ->checkElement('#diaryList div.body', "\n".'Your search "NoMatchingWord" did not match any diaries.')
  ->end()
;
