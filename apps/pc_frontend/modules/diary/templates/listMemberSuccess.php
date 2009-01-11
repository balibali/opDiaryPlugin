<?php use_helper('opDiary'); ?>

<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member))) ?>

<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diaries of %1%', array('%1%' => $member->getName())) ?></h3></div>
<?php if ($pager->getNbResults()): ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/listMember?page=%d&id='.$member->getId()); ?></p></div>
<?php foreach ($pager->getResults() as $diary): ?>
<dl>
<dt><?php echo op_diary_format_date($diary->getCreatedAt(), 'XDateTimeJa') ?></dt>
<dd><?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?><?php if ($diary->hasDiaryImages()) : ?> <?php echo image_tag('icon_camera.gif', array('alt' => 'photo')) ?><?php endif; ?></dd>
</dl>
<?php endforeach; ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/listMember?page=%d&id='.$member->getId()); ?></p></div>
<?php else: ?>
<div class="body">
<?php echo __('There are no diaries') ?>
</div>
<?php endif; ?>
</div></div>

<?php if ($sf_user->getMemberId() === $member->getId()): ?>
<?php echo link_to(__('Post a diary'), 'diary_new') ?>
<?php endif; ?>
