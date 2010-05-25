<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(36);


$t->diag('Diary::getPrevious(), getNext()');

$first  = Doctrine::getTable('Diary')->find(1);
$second = Doctrine::getTable('Diary')->find(4);
$last   = Doctrine::getTable('Diary')->find(5);

$t->ok(!$first->getPrevious(1), 'no previous diary for the first');
$t->is($first->getNext(1)->id, $second->id, 'get next diary');

$t->is($second->getPrevious(1)->id, $first->id, 'get previous diary');
$t->is($second->getNext(1)->id, $last->id, 'get next diary');

$t->is($last->getPrevious(1)->id, $second->id, 'get previous diary');
$t->ok(!$last->getNext(1), 'no next diary for the last');


$t->diag('Diary::getDiaryImages()');

$image1 = Doctrine::getTable('DiaryImage')->find(1);
$t->is($first->getDiaryImages(), array('1' => $image1), 'get diary images');
$t->is($second->getDiaryImages(), array(), 'get empty array');


$t->diag('Diary::isAuthor()');

$t->ok($first->isAuthor(1), 'type int');
$t->ok($first->isAuthor('1'), 'type string');
$t->ok(!$first->isAuthor(0), 'int 0');
$t->ok(!$first->isAuthor('0'), 'string zero');
$t->ok(!$first->isAuthor(NULL), 'null');
$t->ok(!$first->isAuthor(11), 'NG type int');
$t->ok(!$first->isAuthor('11'), 'NG type string');


$t->diag('Diary::isViewable()');

$t->ok(!$first->isAuthor(0), 'int 0');
$t->ok(!$first->isAuthor('0'), 'string zero');
$t->ok(!$first->isAuthor(NULL), 'null');

// PUBLIC_FLAG_SNS
$t->ok($first->isViewable(1), 'OK self');
$t->ok($first->isViewable(2), 'OK friend');
$t->ok($first->isViewable(10), 'OK others');

// PUBLIC_FLAG_FRIEND
$t->ok($second->isViewable(1), 'OK self');
$t->ok($second->isViewable(2), 'OK friend');
$t->ok(!$second->isViewable(10), 'NG others');

// PUBLIC_FLAG_PRIVATE
$t->ok($last->isViewable(1), 'OK self');
$t->ok(!$last->isViewable(2), 'NG friend');
$t->ok(!$last->isViewable(10), 'NG others');


$t->diag('Diary::getDiaryImagesJoinFile()');

$t->is($first->getDiaryImagesJoinFile()->count(), 1, 'count 1');
$t->is($second->getDiaryImagesJoinFile()->count(), 0, 'count 0');


$t->diag('Diary::countDiaryComments()');

$t->is($first->countDiaryComments(), 21, 'count 21');
$t->is($second->countDiaryComments(), 0, 'count 0');


$t->diag('Diary::save()');

$conn = Doctrine::getTable('Diary')->getConnection();
$conn->beginTransaction();

$new = new Diary();
$new->member_id = 1;
$new->public_flag = DiaryTable::PUBLIC_FLAG_OPEN;
$new->save();

$t->is($new->public_flag, DiaryTable::PUBLIC_FLAG_SNS, 'modified public flag');
$t->ok($new->is_open, 'modified is_open flag');

$conn->rollback();


$t->diag('Diary::delete()');

$conn = Doctrine::getTable('Diary')->getConnection();
$conn->beginTransaction();

$file_id = $first->DiaryImages[0]->file_id;
$first->delete();

$t->ok(!Doctrine::getTable('DiaryImage')->find(1), 'DiaryImage is deleted');
$t->ok(!Doctrine::getTable('File')->find($file_id), 'File is deleted');
$t->ok(!Doctrine::getTable('FileBin')->find($file_id), 'FileBin is deleted');

$conn->rollback();
