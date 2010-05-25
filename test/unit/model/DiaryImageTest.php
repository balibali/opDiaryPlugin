<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(4);

$t->diag('DiaryImage::delete()');

$diaryImage = Doctrine::getTable('DiaryImage')->find(1);
$file_id = $diaryImage->file_id;

$conn = Doctrine::getTable('DiaryImage')->getConnection();
$conn->beginTransaction();

$diaryImage->delete();

$t->ok(!Doctrine::getTable('File')->find($file_id), 'File is deleted');
$t->ok(!Doctrine::getTable('FileBin')->find($file_id), 'FileBin is deleted');

$conn->rollback();


$t->diag('DiaryImage::save()');

$conn->beginTransaction();

$file = new File();
$file->name = 'test.gif';

$diaryImage = new DiaryImage();
$diaryImage->diary_id = 1;
$diaryImage->number = 2;
$diaryImage->File = $file;

$diaryImage->save();

$t->is($diaryImage->File->name, 'd_1_2_test.gif', 'File name is prefixed');

$diaryImage->save();

$t->is($diaryImage->File->name, 'd_1_2_test.gif', 'File name is not double prefixed');

$conn->rollback();
