<?php use_helper('Date') ?>

<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member))) ?>

<?php /* {{{ diaryDetailBox */ ?>
<div class="dparts diaryDetailBox"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary of %1%', array('%1%' => $member->getName())) ?></h3>
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
<li><a href="<?php echo sf_image_path($image->getFile()) ?>" target="_blank"><?php echo image_tag_sf_image($image->getFile(), array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php echo nl2br($diary->getBody()) ?>
</div>
</dd>
</dl>
<?php if ($diary->getMemberId() === $sf_user->getMemberId()): ?>
<div class="operation">
<form action="<?php echo url_for('diary_edit', $diary) ?>">
<ul class="moreInfo button">
<li><input type="submit" class="input_submit" value="<?php echo __('Edit this diary') ?>" /></li>
</ul>
</form>
</div>
<?php endif; ?>
</div></div>
<?php /* }}} */ ?>

<?php $comments = $diary->getDiaryComments() ?>
<?php if (count($comments)): ?>
<?php /* {{{ commentList */ ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Comments') ?></h3></div>
<?php foreach ($comments as $comment): ?>
<dl>
<dt><?php echo format_datetime($comment->getCreatedAt(), 'f') ?></dt>
<dd>
<div class="title">
<p class="heading"><strong><?php echo $comment->getNumber() ?></strong>:
<?php if ($_member = $comment->getMember()): ?> <?php echo link_to($_member->getName(), 'member/profile?id='.$_member->getId()) ?><?php endif; ?>
<?php if ($diary->getMemberId() === $sf_user->getMemberId() || $comment->getMemberId() === $sf_user->getMemberId()): ?>
 <?php echo link_to(__('Delete this comment'), 'diary_comment_delete', $comment) ?>
<?php endif; ?>
</p>
</div>
<div class="body">
<?php $images = $comment->getDiaryCommentImages() ?>
<?php if (count($images)): ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->getFile()) ?>" target="_blank"><?php echo image_tag_sf_image($image->getFile(), array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<p class="text"><?php echo nl2br($comment->getBody()) ?></p>
</div>
</dd>
</dl>
<?php endforeach; ?>
</div></div>
<?php /* }}} */ ?>
<?php endif; ?>

<?php
$options = array('form' => array($form));
$title = __('Post a diary comment');
$options['url'] = '@diary_comment_create?id='.$diary->getId();
$options['button'] = __('Save');
$options['isMultipart'] = true;
include_box('formDiaryComment', $title, '', $options);
?>
