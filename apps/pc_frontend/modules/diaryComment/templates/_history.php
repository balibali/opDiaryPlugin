<?php use_helper('opDiary') ?>

<?php if (count($list)): ?>
<div id="homeRecentList_<?php echo $gadget->getId() ?>" class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary Comment History') ?></h3></div>
<div class="block">

<ul class="articleList">
<?php foreach ($list as $diaryCommentUpdate): ?>
<?php $diary = $diaryCommentUpdate->getDiary() ?>
<li><span class="date"><?php echo op_format_date($diaryCommentUpdate->getLastCommentTime(), 'XShortDateJa') ?></span><?php echo link_to(op_diary_get_title_and_count($diary), 'diary_show', $diary) ?> (<?php echo $diary->getMember()->getName() ?>)</li>
<?php endforeach; ?>
</ul>

<div class="moreInfo">
<ul class="moreInfo">
<li><?php echo link_to(__('More'), 'diaryComment/history') ?></li>
</ul>
</div>

</div>
</div></div>
<?php endif; ?>
