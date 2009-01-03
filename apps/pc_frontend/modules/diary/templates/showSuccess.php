<?php use_helper('Date') ?>

<div class="dparts diaryDetailBox"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary of %1%', array('%1%' => $diary->getMember()->getName())) ?></h3>
<p class="public">(<?php echo $diary->getPublicFlagLabel() ?>)</p></div>
<dl>
<dt><?php echo format_datetime($diary->getCreatedAt(), 'f') ?></dt>
<dd>
<div class="title">
<p class="heading"><?php echo $diary->getTitle(); ?></p>
</div>
<div class="body">
<?php $images = $diary->getDiaryImages() ?>
<?php if (count($images)): ?>
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

<div class="parts">
<?php if ($diary->getMemberId() === $sf_user->getMemberId()): ?>
<ul>
<li><?php echo link_to(__('Edit this diary'), 'diary_edit', $diary) ?></li>
<li><form action="<?php echo url_for('diary_delete', $diary) ?>" method="post"><input type="submit" value="<?php echo __('Delete this diary') ?>" /></form></li>
</ul>
<?php endif; ?>
</div>

<?php $comments = $diary->getDiaryComments() ?>
<?php if (count($comments)): ?>
<div class="dparts"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Comments') ?></h3></div>
<?php foreach ($comments as $comment): ?>
<dl>
<dt><?php echo format_datetime($comment->getCreatedAt(), 'f') ?></dt>
<dd><p><?php echo $comment->getMember()->getName() ?></p></dd>
<?php $images = $comment->getDiaryCommentImages() ?>
<?php if (count($images)): ?>
<dd>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><?php echo image_tag_sf_image($image->getFile(), array('size' => '120x120')) ?></li>
<?php endforeach; ?>
</ul>
</dd>
<?php endif; ?>
<dd><p><?php echo nl2br($comment->getBody()) ?></p></dd>
<?php if ($diary->getMemberId() === $sf_user->getMemberId() || $comment->getMemberId() === $sf_user->getMemberId()): ?>
<dd><p><?php echo link_to(__('Delete this comment'), 'diary_comment_delete', $comment) ?></p></dd>
<?php endif; ?>
</dl>
<?php endforeach; ?>
</div></div>
<?php endif; ?>

<?php
$options = array('form' => array($form));
$title = __('Post a diary comment');
$options['url'] = '@diary_comment_create?id='.$diary->getId();
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiaryComment', $title, '', $options);
?>
