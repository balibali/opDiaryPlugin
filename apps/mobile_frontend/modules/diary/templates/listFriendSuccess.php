<?php op_mobile_page_title(__('Diaries of Friends')) ?>
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
              op_format_date($diary->getCreatedAt(), 'XDateTime'),
              link_to(op_diary_get_title_and_count($diary, false, 28), 'diary_show', $diary),
              $diary->getMember()->getName()
            );
}
$options = array(
  'border' => true,
);
op_include_list('diaryList', $list, $options);
?>
<?php echo op_include_pager_navigation($pager, 'diary/listFriend?page=%d', array('is_total' => false)) ?>

<?php else: ?>

<?php echo __('There are no diaries.') ?>

<?php endif; ?>
