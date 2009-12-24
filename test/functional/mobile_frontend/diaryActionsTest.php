<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());
$test->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('sns1@example.com', 'password');
$test->setCulture('en');

$test->get('/diary')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'index')
  ->end()

  ->with('response')->begin()
    ->checkElement('td a', 'Recently Posted Diaries')
  ->end()
;

$countPublicSNS = Doctrine::getTable('Diary')->createQuery()
  ->andWhereIn('public_flag', array(DiaryTable::PUBLIC_FLAG_OPEN, DiaryTable::PUBLIC_FLAG_SNS))
  ->count();

$test->info('Pager Test: diary/list')
  ->get('/diary/list')
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of '.$countPublicSNS)
    ->checkElement('center a', 'Next')
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'list')
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'21 - 40 of '.$countPublicSNS)
    ->checkElement('center a', 'Previous')
    ->checkElement('center a', 'Next', array('position' => 1))
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'list')
    ->isParameter('page', 1)
  ->end()
;

$test->info('Pager Test: diary/listFriend')
  ->get('/diary/listFriend')
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of 21')
    ->checkElement('center a', 'Next')
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listFriend')
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'21 - 21 of 21')
    ->checkElement('center a', 'Previous')
    ->checkElement('center a', 1)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listFriend')
    ->isParameter('page', 1)
  ->end()
;

$test->info('Pager Test: diary/listMember')
  ->get('/diary/listMember/3')
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of 20')
    ->checkElement('center a', false)
  ->end()

  ->get('/diary/listMember/4')
  ->with('response')->begin()
    ->checkElement('center', "\n".'1 - 20 of 31')
    ->checkElement('center a', 'Next')
  ->end()

  ->click('Next')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('page', 2)
  ->end()
  ->with('response')->begin()
    ->checkElement('center', "\n".'21 - 31 of 31')
    ->checkElement('center a', 'Previous')
    ->checkElement('center a', 1)
  ->end()

  ->click('Previous')
  ->with('request')->begin()
    ->isParameter('module', 'diary')
    ->isParameter('action', 'listMember')
    ->isParameter('id', 4)
    ->isParameter('page', 1)
  ->end()
;
