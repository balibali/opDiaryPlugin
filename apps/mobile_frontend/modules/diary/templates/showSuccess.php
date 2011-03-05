<?php op_mobile_page_title(__('Diary of %1%', array('%1%' => $member->getName())), $diary->getTitle()) ?>
<?php use_helper('opDiary') ?>

<?php echo op_within_page_link() ?>
<?php echo op_format_date($diary->getCreatedAt(), 'XDateTime') ?>
<?php if ($diary->getMemberId() === $myMemberId): ?>
[<?php echo link_to(__('Edit'), 'diary_edit', $diary) ?>][<?php echo link_to(__('Delete'), 'diary_delete_confirm', $diary) ?>]
<?php endif; ?><br>

<?php echo op_decoration(nl2br($diary->getBody())) ?><br>

<?php foreach ($diary->getDiaryImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->getFile(), array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>

(<?php echo $diary->getPublicFlagLabel() ?>)<br>

<?php if ($diary->getPrevious($myMemberId) || $diary->getNext($myMemberId)): ?>
<hr>
<center>
<?php if ($diary->getPrevious($myMemberId)): ?> <?php echo link_to(__('Previous Diary'), 'diary_show', $diary->getPrevious($myMemberId)) ?><?php endif; ?>
<?php if ($diary->getNext($myMemberId)): ?> <?php echo link_to(__('Next Diary'), 'diary_show', $diary->getNext($myMemberId)) ?><?php endif; ?>
</center>
<?php endif; ?>

<?php include_component('diaryComment', 'list', array('diary' => $diary)) ?>

<?php if ($myMemberId): ?>
<hr>
<?php echo op_within_page_link('') ?>
<?php
$options['title'] = __('Post a diary comment');
$options['url'] = url_for('diary_comment_create', $diary);
$options['button'] = __('Save');
$options['isMultipart'] = true;
op_include_form('formDiaryComment', $form, $options);
?>

<?php if ('example.com' !== sfConfig::get('op_mail_domain')): ?>
[i:106]<?php echo op_mail_to('mail_diary_comment_create', array('id' => $diary->id), __('Post from E-mail')) ?><br>
<?php echo __('You can attach photo files to e-mail.') ?><br>
<?php endif; ?>

<?php if (DiaryTable::PUBLIC_FLAG_OPEN == $diary->getPublicFlag()): ?>
<br>
<?php echo __('Your comment is visible to all users on the Web.') ?><br>
<?php endif; ?>
<?php endif; ?>

<hr>
<?php echo link_to(__('Diaries of %1%', array('%1%' => $member->getName())), 'diary_list_member', $member) ?><br>
<?php if ($myMemberId && $diary->getMemberId() !== $myMemberId): ?>
<?php echo link_to(__('Profile of %1%', array('%1%' => $member->getName())), 'member/profile?id='.$member->getId()) ?><br>
<?php endif; ?>
