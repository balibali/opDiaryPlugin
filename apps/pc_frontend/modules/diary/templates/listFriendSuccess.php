<?php use_helper('Pagination', 'Date'); ?>

<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diaries of Friends') ?></h3></div>
<?php if ($pager->getNbResults()): ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<?php foreach ($pager->getResults() as $diary): ?>
<dl>
<dt><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></dt>
<dd><?php echo link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId()) ?> (<?php echo $diary->getMember()->getName() ?>)</dd>
</dl>
<?php endforeach; ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<?php else: ?>
<div class="body">
<?php echo __('There are no diaries') ?>
</div>
<?php endif; ?>
</div></div>
