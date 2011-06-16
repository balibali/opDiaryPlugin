<?php use_helper('opDiary'); ?>

<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member, 'year' => $year, 'month' => $month))) ?>

<?php if ($sf_user->getMemberId() === $member->id): ?>
<?php op_include_box('newDiaryLink', link_to(__('Post a diary'), 'diary_new'), array('title' => __('Post a diary'))) ?>
<?php endif; ?>

<?php
$title = __('Diaries of %1%', array('%1%' => $member->name));
if ($year && $month)
{
  $title .= ' ('.op_format_date(sprintf('%04d-%02d-%02d', $year, $month, ($day) ? $day : 1), ($day) ? 'D' : 'XCalendarMonth').')';
}
?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo $title ?></h3></div>
<?php op_include_pager_navigation($pager, '@diary_list_member?page=%d&id='.$member->id.(($year && $month) ? '&year='.$year.'&month='.$month.(($day) ? '&day='.$day : '') : '')); ?>
<?php foreach ($pager->getResults() as $diary): ?>
<dl>
<dt><?php echo op_format_date($diary->created_at, 'XDateTimeJa') ?></dt>
<dd><?php echo op_diary_link_to_show($diary, false) ?></dd>
</dl>
<?php endforeach; ?>
<?php op_include_pager_navigation($pager, '@diary_list_member?page=%d&id='.$member->id.(($year && $month) ? '&year='.$year.'&month='.$month.(($day) ? '&day='.$day : '') : '')); ?>
</div></div>
<?php else: ?>
<?php op_include_box('diaryList', __('There are no diaries.'), array('title' => $title)) ?>
<?php endif; ?>
