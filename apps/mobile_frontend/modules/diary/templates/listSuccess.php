<?php op_mobile_page_title(__('Recently Posted Diaries')) ?>
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
              link_to($diary->getTitleAndCount(false), 'diary_show', $diary),
              $diary->getMember()->getName()
            );
}
$options = array(
  'border' => true,
);
op_include_list('diaryList', $list, $options);
?>
<?php echo pager_navigation($pager, 'diary/list?page=%d', false) ?>

<?php else: ?>

<?php echo __('There are no diaries') ?>

<?php endif; ?>
