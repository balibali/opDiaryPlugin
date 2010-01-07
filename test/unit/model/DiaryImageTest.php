<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(2);

$t->diag('DiaryImage::delete()');

$diaryImage = Doctrine::getTable('DiaryImage')->find(1);
$file_id = $diaryImage->file_id;

$diaryImage->delete();

$t->ok(!Doctrine::getTable('File')->find($file_id), 'File is deleted');
$t->ok(!Doctrine::getTable('FileBin')->find($file_id), 'FileBin is deleted');
