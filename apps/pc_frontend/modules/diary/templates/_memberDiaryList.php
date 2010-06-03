<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<div class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries') ?></h3></div>
<div class="block">

<ul class="articleList">
<?php foreach ($diaryList as $diary): ?>
<li><span class="date"><?php echo op_format_date($diary->created_at, 'XShortDateJa') ?></span><?php echo op_diary_link_to_show($diary, false) ?></li>
<?php endforeach; ?>
</ul>

<div class="moreInfo">
<ul class="moreInfo">
<li><?php echo link_to(__('More'), '@diary_list_member?id='.$memberId) ?></li>
</ul>
</div>

</div>
</div></div>
<?php endif; ?>
