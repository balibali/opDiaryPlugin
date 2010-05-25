<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());
$test->setMobile();

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
    ->checkElement('center', "\n".'1 - 20 of 22')
    ->checkElement('center a', 'Next')
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'21 - 22 of 22')
    ->checkElement('center a', 'Previous')
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diaryComment')
    ->isParameter('action', 'history')
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of 22')
    ->checkElement('center a', 'Next')
  ->end()
;
