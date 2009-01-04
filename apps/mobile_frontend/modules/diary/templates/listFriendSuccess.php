<?php include_page_title(__('Diaries of Friends')) ?>
<?php use_helper('opDiary'); ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php echo pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $diary)
{
  $list[] = sprintf("%s<br>%s (%s)",
              op_diary_format_date($diary->getCreatedAt(), 'XDateTime'),
              link_to($diary->getTitle(), 'diary_show', $diary),
              $diary->getMember()->getName()
            );
}
$options = array(
  'border' => true,
);
include_list_box('diaryList', $list, $options);
?>
<?php echo pager_navigation($pager, 'diary/listFriend?page=%d', false) ?>

<?php else: ?>

<?php echo __('There are no diaries') ?>

<?php endif; ?>
