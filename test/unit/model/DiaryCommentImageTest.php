<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(4);

$t->diag('DiaryCommentImage::delete()');

$dcImage = Doctrine::getTable('DiaryCommentImage')->find(1);
$file_id = $dcImage->file_id;

$conn = Doctrine::getTable('DiaryCommentImage')->getConnection();
$conn->beginTransaction();

$dcImage->delete();

$t->ok(!Doctrine::getTable('File')->find($file_id), 'File is deleted');
$t->ok(!Doctrine::getTable('FileBin')->find($file_id), 'FileBin is deleted');

$conn->rollback();


$t->diag('DiaryCommentImage::save()');

$conn->beginTransaction();

$file = new File();
$file->name = 'test.gif';

$dcImage = new DiaryCommentImage();
$dcImage->diary_comment_id = 1;
$dcImage->File = $file;

$dcImage->save();

$t->is($dcImage->File->name, 'dc_1_test.gif', 'File name is prefixed');

$dcImage->save();

$t->is($dcImage->File->name, 'dc_1_test.gif', 'File name is not double prefixed');

$conn->rollback();
