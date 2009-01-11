<?php use_helper('opDiary') ?>

<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('My Diaries') ?></h3></div>
<div class="box"><div class="body">
<?php if (count($diaryList)): ?>
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo op_diary_format_date($diary->getCreatedAt(), 'XShortDateJa') ?> <?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?><?php if ($diary->hasImages()) : ?> <?php echo image_tag('icon_camera.gif', array('alt' => 'photo')) ?><?php endif; ?></li>
<?php endforeach; ?>
</ul>
<p><?php echo link_to(__('More'), 'diary_list_mine') ?></p>
<?php endif; ?>
<p><?php echo link_to(__('Post a diary'), 'diary_new') ?></p>
</div></div>
</div></div>
