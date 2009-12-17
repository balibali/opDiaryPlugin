<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->setCulture('en');

$test->info('Unauthenticated User Test')
  ->get('/diary/listMember/1/2009/3/1')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/listMember/1/2009/3')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/listMember/1')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/3')
  ->isForwardedTo('diary', 'show')
;

$test->login('sns4@example.com', 'password');
$test->info('AccessBlocked Member Test')
  ->get('/diary/listMember/1/2009/3/1')
  ->isForwardedTo('default', 'error')

  ->get('/diary/listMember/2/2009/3/1')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/listMember/1/2009/3')
  ->isForwardedTo('default', 'error')

  ->get('/diary/listMember/2/2009/3')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/listMember/1')
  ->isForwardedTo('default', 'error')

  ->get('/diary/listMember/2')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/listMember')
  ->isForwardedTo('diary', 'listMember')

  ->get('/diary/1')
  ->isForwardedTo('default', 'error')

  ->get('/diary/2')
  ->isForwardedTo('diary', 'show')

  ->post('/diary/1/comment/create')
  ->isForwardedTo('default', 'error')

  ->post('/diary/2/comment/create')
  ->isForwardedTo('diaryComment', 'create')
;
