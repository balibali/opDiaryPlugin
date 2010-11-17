<?php

$_app = 'pc_backend';
include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$browser = new opTestFunctional(new opBrowser(), new lime_test(null, new lime_output_color()));
$browser
  ->info('Login')
  ->get('/default/login')
  ->click('ログイン', array('admin_user' => array(
    'username' => 'admin',
    'password' => 'password',
  )))
  ->isStatusCode(302)

// CSRF
  ->info('/monitoring/diary/delete/1055 - CSRF')
  ->post('/monitoring/diary/delete/1055')
  ->checkCSRF()

  ->info('/monitoring/diary/comment/delete/1055 - CSRF')
  ->post('/monitoring/diary/comment/delete/1055')
  ->checkCSRF()

// XSS
  ->info('/monitoring/diary - XSS')
  ->get('/monitoring/diary', array('keyword' => 'Diary.title'))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Diary', 'title')
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('Diary', 'body')
  ->end()

  ->info('/monitoring/diary/comment - XSS')
  ->get('/monitoring/diary/comment', array('keyword' => 'Diary.title'))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Diary', 'title')
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('DiaryComment', 'body')
  ->end()

  ->info('/monitoring/diary/deleteConfirm/1055 - XSS')
  ->get('/monitoring/diary/deleteConfirm/1055', array('keyword' => 'Diary.title'))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Diary', 'title')
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('Diary', 'body')
  ->end()

  ->info('/monitoring/diary/comment/deleteConfirm/1055 - XSS')
  ->get('/monitoring/diary/comment/deleteConfirm/1055', array('keyword' => 'Diary.title'))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Diary', 'title')
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('DiaryComment', 'body')
  ->end()
;
