<?php use_helper('opDiary'); ?>

<?php $title = __('Diary Comment History') ?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading"><h3><?php echo $title ?></h3></div>
<?php echo op_include_pager_navigation($pager, '@diary_comment_history?page=%d'); ?>
<?php foreach ($pager->getResults() as $diaryCommentUpdate): ?>
<?php $diary = $diaryCommentUpdate->Diary ?>
<dl>
<dt><?php echo op_format_date($diaryCommentUpdate->last_comment_time, 'XDateTimeJa') ?></dt>
<dd><?php echo op_diary_link_to_show($diary, true, false) ?></dd>
</dl>
<?php endforeach; ?>
<?php echo op_include_pager_navigation($pager, '@diary_comment_history?page=%d'); ?>
</div></div>
<?php else: ?>
<?php op_include_box('diaryList', __('There are no diaries.'), array('title' => $title)) ?>
<?php endif; ?>
