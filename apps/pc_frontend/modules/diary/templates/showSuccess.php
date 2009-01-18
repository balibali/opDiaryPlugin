<?php use_helper('opDiary', 'Text') ?>

<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member, 'year' => $diary->getCreatedAt('Y'), 'month' => $diary->getCreatedAt('n')))) ?>

<?php /* {{{ diaryDetailBox */ ?>
<div class="dparts diaryDetailBox"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary of %1%', array('%1%' => $member->getName())) ?></h3>
<p class="public">(<?php echo $diary->getPublicFlagLabel() ?>)</p></div>

<?php if ($diary->getPrevious() || $diary->getNext()): ?>
<div class="block prevNextLinkLine">
<?php if ($diary->getPrevious()): ?>
<p class="prev"><?php echo link_to(__('Previous Diary'), 'diary_show', $diary->getPrevious()) ?></p>
<?php endif; ?>
<?php if ($diary->getNext()): ?>
<p class="next"><?php echo link_to(__('Next Diary'), 'diary_show', $diary->getNext()) ?></p>
<?php endif; ?>
</div>
<?php endif; ?>

<dl>
<dt><?php echo nl2br(op_diary_format_date($diary->getCreatedAt(), 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<p class="heading"><?php echo $diary->getTitle(); ?></p>
</div>
<div class="body">
<?php $images = $diary->getDiaryImagesJoinFile() ?>
<?php if (count($images)): ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->getFile()) ?>" target="_blank"><?php echo image_tag_sf_image($image->getFile(), array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php echo auto_link_text(nl2br($diary->getBody()), 'urls', array('target' => '_blank'), true, 57) ?>
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

<?php include_component('diaryComment', 'list', array('diary' => $diary)) ?>

<?php
$form->getWidget('body')->setAttribute('rows', 8);
$form->getWidget('body')->setAttribute('cols', 40);

$title = __('Post a diary comment');
$options = array(
  'form' => $form,
  'url' => '@diary_comment_create?id='.$diary->getId(),
  'button' => __('Save'),
  'isMultipart' => true,
);
include_box('formDiaryComment', $title, '', $options);
?>
