<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(7);

$table = Doctrine::getTable('DiaryCommentUnread');

$conn = $table->getConnection();
$conn->beginTransaction();

$t->diag('DiaryCommentUnreadTable::register()');

$diary1 = Doctrine::getTable('Diary')->find(1);

$new = new DiaryComment();
$new->Diary = $diary1;
$new->member_id = 5;
$new->save();

$unread = $table->find(1);
$t->ok($unread, 'unread record is registerd');
$t->is($unread->member_id, 1, 'member_id is owner id');


$t->diag('DiaryCommentUnreadTable::unregister()');

$table->unregister($diary1);

$unread = $table->find(1);
$t->ok(!$unread, 'unread record is unregisterd');


$t->diag('DiaryCommentUnreadTable::countUnreadDiary()');

$t->is($table->countUnreadDiary(1), 0, 'count 0');
$t->is($table->countUnreadDiary(4), 21, 'count 21');


$t->diag('DiaryCommentUnreadTable::getOneDiaryIdByMemberId()');

$t->is($table->getOneDiaryIdByMemberId(1), NULL, 'get NULL');
$t->is($table->getOneDiaryIdByMemberId(2), 2, 'get diary_id 2');


$conn->rollback();
