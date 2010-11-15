<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$test->login('html1@example.com', 'password');

// CSRF
$test
  ->info('/diary/create - CSRF')
  ->post('/diary/create')
  ->checkCSRF()

  ->info('/diary/delete - CSRF')
  ->post('/diary/delete/1055')
  ->checkCSRF()

  ->info('/diary/update - CSRF')
  ->post('/diary/update/1055')
  ->checkCSRF()

  ->info('/diaryComment/create - CSRF')
  ->post('/diary/1055/comment/create')
  ->checkCSRF()

  ->info('/diaryComment/delete - CSRF')
  ->post('/diary/comment/delete/1055')
  ->checkCSRF()

// XSS
  ->info('/diary/edit - XSS')
  ->get('/diary/edit/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('Diary', 'title')
    ->isAllEscapedData('Diary', 'body')
  ->end()

  ->info('/diary/list - XSS')
  ->get('/diary/list')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->countEscapedData(2, 'Diary', 'title', array(
      'width' => 36,
    ))
    ->countEscapedData(2, 'Diary', 'body', array(
      'width' => 36,
      'rows' => 3,
    ))
  ->end()

  ->info('/diary/search - XSS')
  ->get('/diary/search', array('keyword' => opTesterHtmlEscape::getRawTestData('Diary', 'title')))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('Diary', 'title')
    ->countEscapedData(3, 'Diary', 'title', array(
      'width' => 36,
    ))
    ->countEscapedData(2, 'Diary', 'body', array(
      'width' => 36,
      'rows' => 3,
    ))
  ->end()

  ->get('/diary/search', array('keyword' => opTesterHtmlEscape::getRawTestData('DUMMY', 'KEYWORD')))
  ->with('html_escape')->begin()
    ->isAllEscapedData('DUMMY', 'KEYWORD')
  ->end()

  ->info('/diary/_sidemenu - XSS')
  ->get('/diary/edit/1055')
  ->with('html_escape')->begin()
    ->countEscapedData(2, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()

  ->info('/diary/listFriend - XSS')
  ->get('/diary/listFriend')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->countEscapedData(1, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()

  ->info('/diary/listMember - XSS')
  ->get('/diary/listMember')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->countEscapedData(2, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()

  ->get('/diary/listMember', array(
    'year'  => date('Y', strtotime('tomorrow')),
    'month' => date('m', strtotime('tomorrow')),
  ))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->countEscapedData(2, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()

  ->get('/diary/listMember', array(
    'year'  => date('Y', strtotime('tomorrow')),
    'month' => date('m', strtotime('tomorrow')),
    'day'   => date('d', strtotime('tomorrow')),
  ))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->countEscapedData(2, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()

  ->info('/diary/new - XSS')
  ->get('/diary/new')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
  ->end()

  ->info('/diary/show - XSS')
  ->get('/diary/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('Diary', 'title')
    ->isAllEscapedData('Diary', 'body')
    ->isAllEscapedData('DiaryComment', 'body')
  ->end()

  ->info('/diary/comment/history - XSS')
  ->get('/diary/comment/history')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->countEscapedData(1, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()

  ->info('_memberDiaryList - XSS')
  ->get('/member/1055')
  ->with('html_escape')->begin()
    ->countEscapedData(1, 'Diary', 'title', array(
      'width' => 36,
    ))
  ->end()
;
