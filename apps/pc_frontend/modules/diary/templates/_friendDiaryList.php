<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries of Friends') ?></h3></div>
<div class="box"><div class="body">
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo op_diary_format_date($diary->getCreatedAt(), 'XShortDateJa') ?> <?php echo link_to($diary->getTitle(), 'diary_show', $diary) ?></li>
<?php endforeach; ?>
</ul>
<?php echo link_to(__('More'), 'diary/listFriend') ?>
</div></div>
</div></div>
<?php endif; ?>
