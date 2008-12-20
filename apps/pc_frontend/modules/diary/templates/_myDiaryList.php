<?php use_helper('Date') ?>

<div class="dparts"><div class="parts">
<div class="partsHeading"><h3>最近書いた日記</h3></div>
<div class="box"><div class="body">
<?php if (count($diaryList)): ?>
<ul>
<?php foreach ($diaryList as $diary): ?>
<li><?php echo format_date($diary->getCreatedAt()) ?> <?php echo link_to($diary->getTitle(), '@diary_by_id?id='.$diary->getId()) ?></li>
<?php endforeach; ?>
</ul>
<p><?php echo link_to('もっと見る', 'diary/listMember') ?></p>
<?php endif; ?>
<p><?php echo link_to('日記を書く', 'diary/edit') ?></p>
</div></div>
</div></div>
