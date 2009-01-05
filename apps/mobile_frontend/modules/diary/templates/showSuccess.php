<?php include_page_title(__('Diary of %1%', array('%1%' => $member->getName())), $diary->getTitle()) ?>
<?php use_helper('opDiary') ?>

▼<?php echo op_diary_format_date($diary->getCreatedAt(), 'XDateTime') ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Edit'), 'diary_edit', $diary) ?>][<?php echo link_to(__('Delete'), 'diary_delete_confirm', $diary) ?>]
<?php endif; ?><br>

<?php echo nl2br($diary->getBody()) ?><br>

<?php foreach ($diary->getDiaryImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->getFile(), array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>

(<?php echo $diary->getPublicFlagLabel() ?>)<br>

<?php /*
<?php if ($pager->getNbResults()): ?>
<hr>
<center>
<?php echo __('Comments') ?><br>
<?php echo pager_total($pager); ?><br>
</center>

<?php $comments = $pager->getResults(); ?>
<?php foreach ($comments as $comment): ?>
<hr>
▼[<?php printf('%03d', $comment->getNumber()) ?>]<?php echo op_diary_format_date($comment->getCreatedAt(), 'XDateTime') ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId() || $comment->getMemberId() === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Delete'), 'diary_comment_delete_confirm', $comment) ?>]
<?php endif; ?><br>
<?php echo link_to($comment->getMember()->getName(), 'member/show?id='.$comment->getMemberId()) ?><br>
<?php echo nl2br($comment->getBody()) ?><br>
<?php foreach ($comment->getDiaryCommentImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->getFile(), array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endforeach; ?>

<?php echo pager_navigation($pager, '@diary_show?page=%d&id='.$diary->getId(), false) ?>
<?php endif; ?>
*/ ?>

<?php include_component('diaryComment', 'list', array('diary' => $diary)) ?>

<hr>
<?php
$options = array('form' => array($form));
$title = __('Post a diary comment');
$options['url'] = '@diary_comment_create?id='.$diary->getId();
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiaryComment', $title, '', $options);
?>
