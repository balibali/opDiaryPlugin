<?php include_page_title(__('Recently Posted Diaries')) ?>
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
           .link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId())
           .'('.$diary->getMember()->getName().')';
}
$options = array(
  'border' => true,
);
include_list_box('diaryList', $list, $options);
?>
<?php echo pager_navigation($pager, 'diary/list?page=%d', false) ?>

<?php else: ?>

<?php echo __('There are no diaries') ?>

<?php endif; ?>
