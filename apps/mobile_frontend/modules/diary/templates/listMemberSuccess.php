<?php op_mobile_page_title(__('Diaries of %1%', array('%1%' => $member->name))) ?>
<?php use_helper('opDiary'); ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php op_include_pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $diary)
{
  $list[] = sprintf("%s<br>%s",
              op_format_date($diary->created_at, 'XDateTime'),
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary)
            );
}
$options = array(
  'border' => true,
);
op_include_list('diaryList', $list, $options);
?>
<?php echo op_include_pager_navigation($pager, '@diary_list_member?page=%d&id='.$member->id, array('is_total' => false)) ?>

<?php else: ?>

<?php echo __('There are no diaries.') ?>

<?php endif; ?>

<?php if ($sf_user->getMemberId() === $member->id): ?>
<?php echo link_to(__('Post a diary'), 'diary_new') ?>
<?php else: ?>
<?php echo link_to(__('Profile of %1%', array('%1%' => $member->getName())), '@obj_member_profile?id='.$member->getId()) ?>
<?php endif; ?>
