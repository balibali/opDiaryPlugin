<?php use_helper('opDiary') ?>

<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries') ?></h3></div>
<div class="box"><div class="body">
<?php if (count($diaryList)): ?>
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo op_diary_format_date($diary->getCreatedAt(), 'XShortDateJa') ?> <?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?></li>
<?php endforeach; ?>
</ul>
<p><?php echo link_to(__('More'), 'diary/listMember?id='.$sf_user->getMemberId()) ?></p>
<?php endif; ?>
<p><?php echo link_to(__('Post a diary'), 'diary_new') ?></p>
</div></div>
</div></div>
