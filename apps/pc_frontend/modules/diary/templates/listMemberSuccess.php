<?php use_helper('Pagination', 'Date'); ?>

<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diaries of %1%', array('%1%' => $member->getName())) ?></h3></div>
<?php if ($pager->getNbResults()): ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<?php foreach ($pager->getResults() as $diary): ?>
<dl>
<dt><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></dt>
<dd><?php echo link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId()) ?></dd>
</dl>
<?php endforeach; ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/list?page=%d'); ?></p></div>
<?php else: ?>
<div class="body">
<?php echo __('There are no diaries') ?>
</div>
<?php endif; ?>
</div></div>

<?php if ($sf_user->getMemberId() === $member->getId()): ?>
<?php echo link_to(__('Post a diary'), 'diary/edit') ?>
<?php endif; ?>
