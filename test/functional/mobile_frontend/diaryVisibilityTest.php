<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$test = new opTestFunctional(new sfBrowser());
$test->setMobile();

include dirname(__FILE__).'/../../bootstrap/database.php';


$test->info('no-member access to secure diary')
  ->get('/diary/1')  //public_flag = 1 in fixture data
  ->isForwardedTo('member', 'login');