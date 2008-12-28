<?php include_page_title(__('Diaries of %1%', array('%1%' => $member->getName()))) ?>
<?php use_helper('Date'); ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php echo pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $diary)
{
  $list[] = format_datetime($diary->getCreatedAt(), 'f').'<br>'
           .link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId());
}
$options = array(
  'border' => true,
);
include_list_box('diaryList', $list, $options);
?>
<?php echo pager_navigation($pager, 'diary/listMember?page=%d&id='.$member->getId(), false) ?>

<?php else: ?>

<?php echo __('There are no diaries') ?>

<?php endif; ?>

<?php if ($sf_user->getMemberId() === $member->getId()): ?>
<?php echo link_to(__('Post a diary'), 'diary/edit') ?>
<?php endif; ?>
