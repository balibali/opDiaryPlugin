<?php use_helper('Date') ?>

<div class="dparts diaryDetailBox"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary of %1%', array('%1%' => $diary->getMember()->getName())) ?></h3>
<p class="public">(<?php echo __('Public') ?>)</p></div>
<dl>
<dt><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></dt>
<dd>
<div class="title">
<p class="heading"><?php echo $diary->getTitle(); ?></p>
</div>
<div class="body">
<?php if ($images = $diary->getDiaryImages()): ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><?php echo image_tag_sf_image($image->getFile(), array('size' => '120x120')) ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php echo nl2br($diary->getBody()) ?>
</div>
</dd>
</dl>
</div></div>

<?php if ($diary->getMember()->getId() === $sf_user->getMemberId()): ?>
<ul>
<li><?php echo link_to(__('Edit this diary'), 'diary/edit?id='.$diary->getId()) ?></li>
<li><?php echo link_to(__('Delete this diary'), 'diary/delete?id='.$diary->getId()) ?></li>
</ul>
<?php endif; ?>
