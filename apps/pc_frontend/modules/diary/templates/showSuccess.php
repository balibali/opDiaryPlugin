<?php use_helper('Date') ?>

<div class="dparts diaryDetailBox"><div class="parts">
<div class="partsHeading"><h3><?php echo $diary->getMember()->getName() ?>さんの日記</h3>
<p class="public">（全員に公開）</p></div>
<dl>
<dt><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></dt>
<dd>
<div class="title">
<p class="heading"><?php echo $diary->getTitle(); ?></p>
</div>
<div class="body">
<?php echo nl2br($diary->getBody()) ?>
</div>
</dd>
</dl>
</div></div>

<?php if ($diary->getMember()->getId() === $sf_user->getMemberId()): ?>
<ul>
<li><?php echo link_to('この日記を編集する', 'diary/edit?id='.$diary->getId()) ?></li>
<li><?php echo link_to('この日記を削除する', 'diary/delete?id='.$diary->getId()) ?></li>
</ul>
<?php endif; ?>
