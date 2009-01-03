<?php use_helper('Date') ?>

<?php if (count($diaryList)): ?>
<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Diaries') ?></h3></div>
<div class="box"><div class="body">
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo format_date($diary->getCreatedAt()) ?> <?php echo link_to($diary->getTitle(), 'diary_show', $diary) ?></li>
<?php endforeach; ?>
</ul>
<p><?php echo link_to(__('More'), 'diary/listMember?id='.$memberId) ?></p>
</div></div>
</div></div>
<?php endif; ?>
