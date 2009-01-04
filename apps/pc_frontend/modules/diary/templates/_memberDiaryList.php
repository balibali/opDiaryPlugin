<?php use_helper('opDiary') ?>

<?php if (count($diaryList)): ?>
<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries') ?></h3></div>
<div class="box"><div class="body">
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo op_diary_format_date($diary->getCreatedAt(), 'XShortDateJa') ?> <?php echo link_to($diary->getTitleAndCount(), 'diary_show', $diary) ?></li>
<?php endforeach; ?>
</ul>
<p><?php echo link_to(__('More'), 'diary/listMember?id='.$memberId) ?></p>
</div></div>
</div></div>
<?php endif; ?>
