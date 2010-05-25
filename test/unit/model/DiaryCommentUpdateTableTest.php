<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(2);

$table = Doctrine::getTable('DiaryCommentUpdate');


$t->diag('DiaryCommentUpdateTable::getList()');

$member1 = Doctrine::getTable('Member')->find(1);

$t->is($table->getList($member1)->count(), 5, 'count limit');


$t->diag('DiaryCommentUpdateTable::getPager()');

$pager = $table->getPager($member1);
$pager->init();
$t->is(count($pager), 22, 'total count');
