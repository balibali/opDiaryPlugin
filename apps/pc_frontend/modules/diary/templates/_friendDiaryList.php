<?php use_helper('Date') ?>

<div class="dparts"><div class="parts">
<div class="partsHeading"><h3>マイフレンド最新日記</h3></div>
<div class="box"><div class="body">
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo format_date($diary->getCreatedAt()) ?> <?php echo link_to($diary->getTitle(), 'diary/show?id='.$diary->getId()) ?></li>
<?php endforeach; ?>
</ul>
</div></div>
</div></div>
