<?php slot('title', __('Diary Comment List')) ?>

<?php slot('submenu') ?>
<?php include_component('monitoring', 'submenu') ?>
<?php end_slot() ?>

<?php include_partial('searchForm') ?>

<?php
if (isset($diaryId))
{
  $pagerLink = '@monitoring_diary_comment_search?diary_id='.$diaryId.'&page=%d';
}
elseif (isset($keyword))
{
  $pagerLink = '@monitoring_diary_comment_search?keyword='.$keyword.'&page=%d';
}
else
{
  $pagerLink = '@monitoring_diary_comment?page=%d';
}
?>
<?php if ($pager->getNbResults()): ?>
<div id="diaryMonitoringList">
<p><?php echo op_include_pager_navigation($pager, $pagerLink) ?></p>
<?php foreach ($pager->getResults() as $diaryComment): ?>
<table>
<?php include_partial('diaryComment', array('diaryComment' => $diaryComment)) ?>
<tr><td colspan="2"><form action="<?php echo url_for('@monitoring_diary_comment_delete_confirm?id='.$diaryComment->id) ?>" method="get"><input type="submit" value="<?php echo __('Delete') ?>" /></form></td></tr>
</table>
<?php endforeach; ?>
<p><?php echo op_include_pager_navigation($pager, $pagerLink) ?></p>
</div>
<?php else: ?>
<p><?php echo !isset($keyword) ? __('There are no diary comments.') : __('Your search "%1%" did not match any diary comments.', array('%1%' => $keyword)) ?></p>
<?php endif; ?>
