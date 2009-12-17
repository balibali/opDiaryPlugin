<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());
$test->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->info('Search Test')
  ->get('/diary/list')
  ->with('response')->begin()
    ->checkElement('#diarySearchForm', true)
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
    ->checkElement('center', "\n".'1 - 20 of 51')
    ->checkElement('center a', 'Next')
    ->checkElement('td a', 'Search Results')
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'21 - 40 of 51')
    ->checkElement('center a', 'Previous')
    ->checkElement('center a', 'Next', array('position' => 1))
    ->checkElement('td a', 'Search Results')
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of 51')
    ->checkElement('center a', 'Next')
    ->checkElement('td a', 'Search Results')
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
    ->checkElement('center', "\n".'1 - 20 of 21')
    ->checkElement('center a', 'Next')
    ->checkElement('td a', 'Search Results')
  ->end()

  ->click('Next', array('keyword' => $keyword))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'21 - 21 of 21')
    ->checkElement('center a', 'Previous')
    ->checkElement('td a', 'Search Results')
  ->end()

  ->click('Previous', array('keyword' => $keyword))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
    ->isParameter('page', 1)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of 21')
    ->checkElement('center a', 'Next')
    ->checkElement('td a', 'Search Results')
  ->end()
;

$keyword = 'NoMatchingWord';
$test->info('Search Test: '.$keyword)
  ->get('/diary/list')
  ->click('Search', array('keyword' => $keyword))
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'search')
    ->isParameter('keyword', $keyword)
  ->end()
  ->with('response')->begin()
    ->checkElement('td a', 'Search Results')
    ->matches('/Your search "'.$keyword.'" did not match any diaries\./')
  ->end()
;
