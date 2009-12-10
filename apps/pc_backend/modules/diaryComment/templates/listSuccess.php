<?php slot('title', __('Diary Comment List')) ?>

<?php slot('submenu') ?>
<?php include_component('monitoring', 'submenu') ?>
<?php end_slot() ?>

<?php if ($pager->getNbResults()): ?>
<div id="diaryMonitoringList">
<p><?php echo op_include_pager_navigation($pager, 'diaryComment/list?page=%d'); ?></p>
<?php foreach ($pager->getResults() as $diaryComment): ?>
<table>
<tr><th><?php echo __('ID') ?></th><td><?php echo $diaryComment->id ?></td></tr>
<tr><th><?php echo __('Diary') ?></th><td><?php echo $diaryComment->Diary->title ?> (<?php echo __('ID') ?>: <?php echo $diaryComment->diary_id ?>)</td></tr>
<tr><th><?php echo __('Author') ?></th><td><?php echo $diaryComment->Member->name ?></td></tr>
<tr><th><?php echo __('Created at') ?></th><td><?php echo op_format_date($diaryComment->created_at, 'XDateTimeJa') ?></td></tr>
<tr><th><?php echo __('Body') ?></th><td><?php echo nl2br($diaryComment->body) ?></td></tr>
<tr><td colspan="2"><form action="<?php echo url_for('diaryComment/deleteConfirm?id='.$diaryComment->id) ?>" method="get"><input type="submit" value="<?php echo __('Delete') ?>" /></form></td></tr>
</table>
<?php endforeach; ?>
<p><?php echo op_include_pager_navigation($pager, 'diaryComment/list?page=%d'); ?></p>
</div>
<?php else: ?>
<p><?php echo __('There are no diary comments.') ?></p>
<?php endif; ?>
