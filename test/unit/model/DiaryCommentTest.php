<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(12);


$t->diag('DiaryComment::getDiaryCommentImagesJoinFile()');

$first = Doctrine::getTable('DiaryComment')->find(1);

$t->is($first->getDiaryCommentImagesJoinFile()->count(), 1, 'count 1');

$conn = Doctrine::getTable('DiaryComment')->getConnection();
$conn->beginTransaction();

$first->DiaryCommentImages->delete();
$t->is($first->getDiaryCommentImagesJoinFile()->count(), 0, 'count 0');

$conn->rollback();


$t->diag('DiaryComment::isDeletable()');

$first = Doctrine::getTable('DiaryComment')->find(1);

$t->ok(!$first->isDeletable(0), 'int 0');
$t->ok(!$first->isDeletable('0'), 'string zero');
$t->ok(!$first->isDeletable(NULL), 'null');

$t->ok($first->isDeletable(1), 'OK commenter');
$t->ok($first->isDeletable(2), 'OK owner');
$t->ok(!$first->isDeletable(3), 'NG other');


$t->diag('DiaryComment::save()');

$conn = Doctrine::getTable('DiaryComment')->getConnection();
$conn->beginTransaction();

$new = new DiaryComment();
$new->diary_id = 1;
$new->member_id = 1;
$new->save();

$t->is($new->number, 22, 'set next number');

$conn->rollback();


$t->diag('DiaryComment::delete()');

$first = Doctrine::getTable('DiaryComment')->find(1);

$conn = Doctrine::getTable('DiaryComment')->getConnection();
$conn->beginTransaction();

$file_id = $first->DiaryCommentImages[0]->file_id;
$first->delete();

$t->ok(!Doctrine::getTable('DiaryCommentImage')->find(1), 'DiaryImage is deleted');
$t->ok(!Doctrine::getTable('File')->find($file_id), 'File is deleted');
$t->ok(!Doctrine::getTable('FileBin')->find($file_id), 'FileBin is deleted');

$conn->rollback();
