<?php slot('title', __('Diary List')) ?>

<?php slot('submenu') ?>
<?php include_component('monitoring', 'submenu') ?>
<?php end_slot() ?>

<?php include_partial('searchForm') ?>

<?php if ($diary): ?>
<div id="diaryMonitoringList">
<table>
<?php include_partial('diary', array('diary' => $diary)) ?>
<tr><td colspan="2"><form action="<?php echo url_for('@monitoring_diary_delete_confirm?id='.$diary->id) ?>" method="get"><input type="submit" value="<?php echo __('Delete') ?>" /></form></td></tr>
</table>
</div>
<?php else: ?>
<p><?php echo __('Your search "%1%" did not match any diaries.', array('%1%' => $sf_request->getParameter('id'))) ?></p>
<?php endif; ?>
