<?php op_mobile_page_title(__('Diary of %1%', array('%1%' => $member->name)), $diary->title) ?>
<?php use_helper('opDiary') ?>

<?php echo op_within_page_link() ?>
<?php echo op_format_date($diary->created_at, 'XDateTime') ?>
<?php if ($diary->member_id === $sf_user->getMemberId()): ?>
[<?php echo link_to(__('Edit'), 'diary_edit', $diary) ?>][<?php echo link_to(__('Delete'), 'diary_delete_confirm', $diary) ?>]
<?php endif; ?><br>

<?php echo op_decoration(nl2br($diary->body)) ?><br>

<?php if ($diary->has_images): ?>
<?php foreach ($diary->getDiaryImages() as $image): ?>
<?php echo link_to(__('View Image'), sf_image_path($image->File, array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endif; ?>

(<?php echo $diary->getPublicFlagLabel() ?>)<br>

<?php if ($diary->getPrevious($sf_user->getMemberId()) || $diary->getNext($sf_user->getMemberId())): ?>
<hr color="<?php echo $op_color["core_color_11"] ?>">
<center>
<?php if ($diary->getPrevious($sf_user->getMemberId())): ?> <?php echo link_to(__('Previous Diary'), 'diary_show', $diary->getPrevious($sf_user->getMemberId())) ?><?php endif; ?>
<?php if ($diary->getNext($sf_user->getMemberId())): ?> <?php echo link_to(__('Next Diary'), 'diary_show', $diary->getNext($sf_user->getMemberId())) ?><?php endif; ?>
</center>
<?php endif; ?>

<?php include_component('diaryComment', 'list', array('diary' => $diary)) ?>

<?php if ($sf_user->getMemberId()): ?>
<hr color="<?php echo $op_color["core_color_11"] ?>">
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
<?php endif; ?>

<hr color="<?php echo $op_color["core_color_11"] ?>">
<?php echo link_to(__('Diaries of %1%', array('%1%' => $member->name)), 'diary_list_member', $member) ?><br>
<?php if ($diary->member_id !== $sf_user->getMemberId()): ?>
<?php echo link_to(__('Profile of %1%', array('%1%' => $member->name)), 'member/profile?id='.$member->id) ?><br>
<?php endif; ?>
