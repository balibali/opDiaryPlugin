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
  ->info('/opDiaryPlugin/index - CSRF')
  ->post('/opDiaryPlugin/index')
  ->checkCSRF()
;
