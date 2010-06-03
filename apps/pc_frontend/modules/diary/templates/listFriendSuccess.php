<?php use_helper('opDiary'); ?>

<?php $title = __('Diaries of %my_friend%', array('%my_friend%' => $op_term['my_friend']->pluralize()->titleize())) ?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo $title ?></h3></div>
<?php echo op_include_pager_navigation($pager, '@diary_list_friend?page=%d'); ?>
<?php foreach ($pager->getResults() as $diary): ?>
<dl>
<dt><?php echo op_format_date($diary->created_at, 'XDateTimeJa') ?></dt>
<dd><?php echo op_diary_link_to_show($diary) ?></dd>
</dl>
<?php endforeach; ?>
<?php echo op_include_pager_navigation($pager, '@diary_list_friend?page=%d'); ?>
</div></div>
<?php else: ?>
<?php op_include_box('diaryList', __('There are no diaries.'), array('title' => $title)) ?>
<?php endif; ?>
