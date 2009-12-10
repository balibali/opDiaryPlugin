<?php slot('title', __('Diary List')) ?>

<?php slot('submenu') ?>
<?php include_component('monitoring', 'submenu') ?>
<?php end_slot() ?>

<?php if ($pager->getNbResults()): ?>
<div id="diaryMonitoringList">
<p><?php echo op_include_pager_navigation($pager, 'diary/list?page=%d'); ?></p>
<?php foreach ($pager->getResults() as $diary): ?>
<table>
<tr><th><?php echo __('ID') ?></th><td><?php echo $diary->id ?></td></tr>
<tr><th><?php echo __('Title') ?></th><td><?php echo $diary->title ?></td></tr>
<tr><th><?php echo __('Author') ?></th><td><?php echo $diary->Member->name ?></td></tr>
<tr><th><?php echo __('Created at') ?></th><td><?php echo op_format_date($diary->created_at, 'XDateTimeJa') ?></td></tr>
<tr><th><?php echo __('Body') ?></th><td><?php echo nl2br($diary->body) ?></td></tr>
<tr><td colspan="2"><form action="<?php echo url_for('diary/deleteConfirm?id='.$diary->id) ?>" method="get"><input type="submit" value="<?php echo __('Delete') ?>" /></form></td></tr>
</table>
<?php endforeach; ?>
<p><?php echo op_include_pager_navigation($pager, 'diary/list?page=%d'); ?></p>
</div>
<?php else: ?>
<p><?php echo __('There are no diaries.') ?></p>
<?php endif; ?>
