<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<div class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries of Friends') ?></h3></div>
<div class="block">

<ul class="articleList">
<?php foreach ($diaryList as $diary): ?>
<li><span class="date"><?php echo op_diary_format_date($diary->getCreatedAt(), 'XShortDateJa') ?></span><?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?> (<?php echo $diary->getMember()->getName() ?>)<?php if ($diary->hasImages()) : ?> <?php echo image_tag('icon_camera.gif', array('alt' => 'photo')) ?><?php endif; ?></li>
<?php endforeach; ?>
</ul>

<div class="moreInfo">
<ul class="moreInfo">
<li><?php echo link_to(__('More'), 'diary/listFriend') ?></li>
</ul>
</div>

</div>
</div></div>
<?php endif; ?>
