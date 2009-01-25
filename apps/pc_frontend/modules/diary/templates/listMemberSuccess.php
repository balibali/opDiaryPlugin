<?php use_helper('opDiary'); ?>

<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member, 'year' => $year, 'month' => $month))) ?>

<?php if ($sf_user->getMemberId() === $member->getId()): ?>
<?php op_include_box('newDiaryLink', link_to(__('Post a diary'), 'diary_new'), array('title' => __('Post a diary'))) ?>
<?php endif; ?>

<?php
$title = __('Diaries of %1%', array('%1%' => $member->getName()));
if ($year && $month)
{
  $title .= ' ('.op_diary_format_date(sprintf('%04d-%02d-%02d', $year, $month, ($day) ? $day : 1), ($day) ? 'D' : 'XCalendarMonth').')';
}
?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo $title ?></h3></div>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/listMember?page=%d&id='.$member->getId()); ?></p></div>
<?php foreach ($pager->getResults() as $diary): ?>
<dl>
<dt><?php echo op_diary_format_date($diary->getCreatedAt(), 'XDateTimeJa') ?></dt>
<dd><?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?><?php if ($diary->hasImages()) : ?> <?php echo image_tag('icon_camera.gif', array('alt' => 'photo')) ?><?php endif; ?></dd>
</dl>
<?php endforeach; ?>
<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, 'diary/listMember?page=%d&id='.$member->getId()); ?></p></div>
</div></div>
<?php else: ?>
<?php op_include_box('diaryList', __('There are no diaries'), array('title' => $title)) ?>
<?php endif; ?>
