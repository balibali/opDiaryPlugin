<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries of All') ?></h3></div>
<div class="box"><div class="body">
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo op_diary_format_date($diary->getCreatedAt(), 'XShortDateJa') ?> <?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?><?php if ($diary->hasDiaryImages()) : ?> <?php echo image_tag('icon_camera.gif', array('alt' => 'photo')) ?><?php endif; ?></li>
<?php endforeach; ?>
</ul>
<p><?php echo link_to(__('More'), 'diary/list') ?></p>
</div></div>
</div></div>
<?php endif; ?>
